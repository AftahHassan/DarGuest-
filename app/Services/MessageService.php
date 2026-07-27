<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;

class MessageService
{
    public function send(Conversation $conversation, User $sender, string $content): Message
    {
        return $conversation->messages()->create([
            'sender_id' => $sender->id,
            'sender_type' => $sender->role,
            'message' => $content,
        ]);

        // Note : le dispatch du Job d'analyse IA sera ajouté en Phase 7,
        // une fois le service FastAPI créé.
    }
}