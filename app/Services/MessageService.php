<?php

namespace App\Services;

use App\Jobs\AnalyzeMessageJob;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function send(Conversation $conversation, User $sender, string $content): Message
    {
        $message = $conversation->messages()->create([
            'sender_id' => $sender->id,
            'sender_type' => $sender->role,
            'message' => $content,
        ]);

        if ($sender->isGuest()) {
            AnalyzeMessageJob::dispatch($message)->onQueue('ai-analysis');
        }

        return $message;
    }
}

