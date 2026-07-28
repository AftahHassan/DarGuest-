<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Notification;
use App\Models\Property;
use App\Models\Reservation;
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

        $stats = [
            'total_properties' => $propertyIds->count(),
            'available_properties' => Property::whereIn('id', $propertyIds)->where('status', 'available')->count(),
            'total_reservations' => Reservation::whereIn('property_id', $propertyIds)->count(),
            'pending_reservations' => Reservation::whereIn('property_id', $propertyIds)->where('status', 'pending')->count(),
            'unread_notifications' => $user->notifications()->where('is_read', false)->count(),
            'urgent_messages' => \App\Models\AiAnalysis::where('urgency', true)
                ->whereHas('message.conversation.reservation.property', fn ($q) => $q->where('owner_id', $user->id))
                ->count(),
        ];

        $recentProperties = Property::where('owner_id', $user->id)->latest()->take(5)->get();

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

        return view('dashboard.owner', compact('stats', 'recentProperties', 'recentConversations', 'urgentAnalyses'));
    }

    protected function guestDashboard($user): View
    {
        $stats = [
            'total_reservations' => Reservation::where('guest_id', $user->id)->count(),
            'upcoming_reservations' => Reservation::where('guest_id', $user->id)
                ->where('check_in_date', '>=', now())
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'unread_notifications' => $user->notifications()->where('is_read', false)->count(),
        ];

        $availableProperties = Property::available()->latest()->take(6)->get();

        $upcomingReservations = Reservation::where('guest_id', $user->id)
            ->where('check_in_date', '>=', now())
            ->with('property')
            ->orderBy('check_in_date')
            ->take(3)
            ->get();

        return view('dashboard.guest', compact('stats', 'availableProperties', 'upcomingReservations'));
    }
}