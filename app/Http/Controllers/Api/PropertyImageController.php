<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyImageRequest;
use App\Http\Resources\PropertyImageResource;
use App\Models\Property;
use App\Models\PropertyImage;

class PropertyImageController extends Controller
{
    public function store(StorePropertyImageRequest $request, Property $property)
    {
        $startPosition = $property->images()->max('position') + 1;

        $images = collect($request->file('images'))->map(function ($file, $index) use ($property, $startPosition) {
            $path = $file->store('properties', 'public');

            return $property->images()->create([
                'image' => $path,
                'position' => $startPosition + $index,
            ]);
        });

        return PropertyImageResource::collection($images);
    }

    public function destroy(PropertyImage $propertyImage)
    {
        $this->authorize('update', $propertyImage->property);

        \Illuminate\Support\Facades\Storage::disk('public')->delete($propertyImage->image);
        $propertyImage->delete();

        return response()->json(['message' => 'Image supprimée.'], 200);
    }
}