<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Conversation;
use App\Services\MessageService;
use Illuminate\Http\RedirectResponse;

class ConversationController extends Controller
{
    public function __construct(protected MessageService $messages) {}

    public function index(): \Illuminate\View\View
    {
        $query = \App\Models\Conversation::whereHas('reservation', function ($q) {
            $q->where('guest_id', auth()->id())
              ->orWhereHas('property', fn($q) => $q->where('owner_id', auth()->id()));
        });

        $conversations = (clone $query)->with([
            'reservation.property',
            'reservation.guest',
            'messages' => fn($q) => $q->reorder()->latest()->limit(1),
        ])->withCount([
            'messages as unread_count' => fn($q) => $q->where('sender_type', '!=', 'ai')
                ->where('sender_id', '!=', auth()->id())
                ->whereNull('read_at'),
        ])->latest()->get();

        $active = null;
        if (request()->filled('conversation')) {
            $active = (clone $query)->find(request('conversation'));
            $active?->load(['reservation.property', 'reservation.guest', 'messages.aiAnalysis']);
            $active?->markAsRead(auth()->id());
        }

        return view('conversations.index', compact('conversations', 'active'));
    }

    public function show(Conversation $conversation): \Illuminate\View\View
    {
        $this->authorize('view', $conversation);

        $conversations = \App\Models\Conversation::whereHas('reservation', function ($q) {
            $q->where('guest_id', auth()->id())
              ->orWhereHas('property', fn($q) => $q->where('owner_id', auth()->id()));
        })->with([
            'reservation.property',
            'reservation.guest',
            'messages' => fn($q) => $q->reorder()->latest()->limit(1),
        ])->withCount([
            'messages as unread_count' => fn($q) => $q->where('sender_type', '!=', 'ai')
                ->where('sender_id', '!=', auth()->id())
                ->whereNull('read_at'),
        ])->latest()->get();

        $conversation->load(['reservation.property', 'reservation.guest', 'messages.aiAnalysis']);

        $conversation->markAsRead(auth()->id());

        return view('conversations.show', compact('conversation', 'conversations'));
    }

    public function storeMessage(StoreMessageRequest $request, Conversation $conversation): RedirectResponse
    {
        $this->messages->send($conversation, $request->user(), $request->validated('message'));

        return back();
    }
}