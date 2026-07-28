<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(protected MessageService $messages) {}

    public function index(Conversation $conversation): JsonResponse
    {
        $this->authorize('view', $conversation);
        $conversation->load('messages.sender');
        return response()->json($conversation->messages);
    }

    public function store(Request $request, Conversation $conversation): JsonResponse
    {
        $this->authorize('view', $conversation);
        $request->validate(['message' => 'required|string|max:2000']);
        $msg = $this->messages->send($conversation, $request->user(), $request->message);
        return response()->json($msg, 201);
    }
}
