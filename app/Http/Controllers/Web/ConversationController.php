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

    public function storeMessage(StoreMessageRequest $request, Conversation $conversation): RedirectResponse
    {
        $this->messages->send($conversation, $request->user(), $request->validated('message'));

        return back();
    }
}