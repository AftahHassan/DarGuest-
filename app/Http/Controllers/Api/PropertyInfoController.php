<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyInfoRequest;
use App\Http\Resources\PropertyInfoResource;
use App\Models\Property;

class PropertyInfoController extends Controller
{
    public function show(Property $property)
    {
        return new PropertyInfoResource($property->info);
    }

    public function update(StorePropertyInfoRequest $request, Property $property)
    {
        $info = $property->info()->updateOrCreate(
            ['property_id' => $property->id],
            $request->validated()
        );

        return new PropertyInfoResource($info);
    }
}