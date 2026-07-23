<?php

namespace App\Policies;

use App\Models\Recommendation;
use App\Models\User;

class RecommendationPolicy
{
    public function update(User $user, Recommendation $recommendation): bool
    {
        return $user->id === $recommendation->property->owner_id;
    }

    public function delete(User $user, Recommendation $recommendation): bool
    {
        return $user->id === $recommendation->property->owner_id;
    }
}