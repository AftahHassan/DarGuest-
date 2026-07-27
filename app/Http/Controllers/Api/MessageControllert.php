<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Conversation;
use App\Services\MessageService;

class MessageController extends Controller
{
    public function __construct(protected MessageService $messages) {}

    public function index(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        return MessageResource::collection(
            $conversation->messages()->with('sender')->paginate(30)
        );
    }

    public function store(StoreMessageRequest $request, Conversation $conversation)
    {
        $message = $this->messages->send($conversation, $request->user(), $request->validated('message'));

        return new MessageResource($message->load('sender'));
    }
}