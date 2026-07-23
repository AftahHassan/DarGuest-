<?php

namespace App\Services;

use App\Models\Property;
use App\Models\User;

class PropertyService
{
    public function create(User $owner, array $data): Property
    {
        return Property::create([...$data, 'owner_id' => $owner->id]);
    }

    public function update(Property $property, array $data): Property
    {
        $property->update($data);

        return $property->fresh();
    }

    public function delete(Property $property): void
    {
        $property->delete();
    }
}