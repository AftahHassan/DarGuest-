<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConversationResource;
use App\Models\Conversation;

class ConversationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $query = $user->isOwner()
            ? Conversation::whereHas('reservation.property', fn ($q) => $q->where('owner_id', $user->id))
            : Conversation::whereHas('reservation', fn ($q) => $q->where('guest_id', $user->id));

        return ConversationResource::collection(
            $query->with('reservation.property', 'reservation.guest')->latest()->paginate(15)
        );
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);

        return new ConversationResource($conversation->load('reservation.property', 'reservation.guest'));
    }
}