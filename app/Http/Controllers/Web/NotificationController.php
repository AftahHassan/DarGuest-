<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $query = auth()->user()->notifications();

        if (request()->filled('type')) {
            $query->where('type', request('type'));
        }

        if (request()->boolean('unread')) {
            $query->unread();
        }

        $notifications = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => auth()->user()->notifications()->count(),
            'unread' => auth()->user()->notifications()->unread()->count(),
            'urgent' => auth()->user()->notifications()->where('type', 'emergency')->unread()->count(),
        ];

        return view('notifications.index', compact('notifications', 'stats'));
    }

    public function markAsRead(Notification $notification): RedirectResponse
    {
        $this->authorize('update', $notification);

        $notification->update(['is_read' => true]);

        return request()->method() === 'GET'
            ? redirect()->route('notifications.index')
            : back();
    }

    public function markAllAsRead(): RedirectResponse
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back()->with('status', 'Toutes les notifications sont marquées comme lues.');
    }

    public function destroy(Notification $notification): RedirectResponse
    {
        $this->authorize('update', $notification);

        $notification->delete();

        return back()->with('status', 'Notification supprimée.');
    }
}