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
        $conversations = \App\Models\Conversation::whereHas('reservation', function ($q) {
            $q->where('guest_id', auth()->id())
              ->orWhereHas('property', fn($q) => $q->where('user_id', auth()->id()));
        })->with(['reservation.property', 'reservation.guest', 'messages' => fn($q) => $q->latest()->limit(1)])
          ->latest()->get();

        return view('conversations.index', compact('conversations'));
    }

    public function show(Conversation $conversation): \Illuminate\View\View
    {
        $conversation->load(['reservation.property', 'reservation.guest', 'messages.aiAnalysis']);
        return view('conversations.show', compact('conversation'));
    }

    public function storeMessage(StoreMessageRequest $request, Conversation $conversation): RedirectResponse
    {
        $this->messages->send($conversation, $request->user(), $request->validated('message'));

        return back();
    }
}