<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\Notification;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isOwner()) {
            return $this->ownerDashboard($user);
        }

        return $this->guestDashboard($user);
    }

    protected function ownerDashboard($user): View
    {
        $propertiesQuery = Property::where('owner_id', $user->id);

        $stats = [
            'total_properties' => (clone $propertiesQuery)->count(),
            'available_properties' => (clone $propertiesQuery)->where('status', 'available')->count(),
            'total_reservations' => Reservation::whereHas('property', fn ($q) => $q->where('owner_id', $user->id))->count(),
            'unread_notifications' => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
        ];

        $recentProperties = (clone $propertiesQuery)->latest()->take(5)->get();

        return view('dashboard.owner', compact('stats', 'recentProperties'));
    }

    protected function guestDashboard($user): View
    {
        $stats = [
            'total_reservations' => Reservation::where('guest_id', $user->id)->count(),
            'upcoming_reservations' => Reservation::where('guest_id', $user->id)
                ->where('check_in_date', '>=', now())
                ->count(),
            'unread_notifications' => Notification::where('user_id', $user->id)->where('is_read', false)->count(),
        ];

        $availableProperties = Property::available()->latest()->take(6)->get();

        return view('dashboard.guest', compact('stats', 'availableProperties'));
    }
}