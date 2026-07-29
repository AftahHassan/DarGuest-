<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Property;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        return $user->isOwner()
            ? $this->ownerDashboard($user)
            : $this->guestDashboard($user);
    }

    protected function ownerDashboard($user): View
    {
        $propertyIds = Property::where('owner_id', $user->id)->pluck('id');

        $totalProperties = $propertyIds->count();
        $totalReservations = Reservation::whereIn('property_id', $propertyIds)->count();

        $stats = [
            'total_properties'      => $totalProperties,
            'available_properties'  => Property::whereIn('id', $propertyIds)->where('status', 'available')->count(),
            'total_reservations'    => $totalReservations,
            'pending_reservations'  => Reservation::whereIn('property_id', $propertyIds)->where('status', 'pending')->count(),
            'unread_notifications'  => $user->notifications()->where('is_read', false)->count(),
            'urgent_messages'       => \App\Models\AiAnalysis::where('urgency', true)
                ->whereHas('message.conversation.reservation.property', fn ($q) => $q->where('owner_id', $user->id))
                ->count(),
            'total_revenue'         => Reservation::whereIn('property_id', $propertyIds)
                ->where('status', 'confirmed')
                ->sum('total_price'),
            'ai_messages_count'     => \App\Models\AiAnalysis::whereHas(
                'message.conversation.reservation.property',
                fn ($q) => $q->where('owner_id', $user->id)
            )->count(),
            'ai_time_saved'         => \App\Models\AiAnalysis::whereHas(
                'message.conversation.reservation.property',
                fn ($q) => $q->where('owner_id', $user->id)
            )->where('urgency', false)->count() * 5,
        ];

        $recentProperties = Property::where('owner_id', $user->id)->with('images')->latest()->take(6)->get();

        $recentConversations = Conversation::whereHas('reservation.property', fn ($q) => $q->where('owner_id', $user->id))
            ->with('reservation.property', 'reservation.guest')
            ->latest()
            ->take(5)
            ->get();

        $urgentAnalyses = \App\Models\AiAnalysis::where('urgency', true)
            ->whereHas('message.conversation.reservation.property', fn ($q) => $q->where('owner_id', $user->id))
            ->with('message.conversation.reservation.property')
            ->latest()
            ->take(5)
            ->get();

        $recentReservations = Reservation::whereIn('property_id', $propertyIds)
            ->with('property', 'guest')
            ->latest()
            ->take(8)
            ->get();

        $monthlyRevenue = Reservation::whereIn('property_id', $propertyIds)
            ->where('status', 'confirmed')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyBookings = Reservation::whereIn('property_id', $propertyIds)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $stats['revenue_change'] = 12;
        $stats['reservation_change'] = 8;
        $stats['property_change'] = 0;
        $stats['ai_change'] = 25;

        return view('dashboard.owner', compact(
            'stats',
            'recentProperties',
            'recentConversations',
            'urgentAnalyses',
            'recentReservations',
            'monthlyRevenue',
            'monthlyBookings'
        ));
    }

    protected function guestDashboard($user): View
    {
        $stats = [
            'total_reservations'    => Reservation::where('guest_id', $user->id)->count(),
            'upcoming_reservations' => Reservation::where('guest_id', $user->id)
                ->where('check_in_date', '>=', now())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'unread_notifications'  => $user->notifications()->where('is_read', false)->count(),
        ];

        $availableProperties = Property::available()->with('images')->latest()->take(6)->get();

        $upcomingReservations = Reservation::where('guest_id', $user->id)
            ->where('check_in_date', '>=', now())
            ->with('property.images')
            ->orderBy('check_in_date')
            ->take(3)
            ->get();

        return view('dashboard.guest', compact('stats', 'availableProperties', 'upcomingReservations'));
    }
}
