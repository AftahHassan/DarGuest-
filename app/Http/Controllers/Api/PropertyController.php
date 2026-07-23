<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use App\Services\PropertyService;


class PropertyController extends Controller
{
    public function  __construct(protected PropertyService $properties){}

    public function index()
    {
        return PropertyResource::collection(
            Property::available()->with('images', 'info')->paginate(15)
        );
    }

    
    public function store(StorePropertyRequest $request)
    {
        $property = $this->properties->create($request->user(), $request->validated());

        return new PropertyResource($property);
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);

        return new PropertyResource($property->load('images', 'info', 'recommendations'));
    }

    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property = $this->properties->update($property, $request->validated());

        return new PropertyResource($property);
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);

        $this->properties->delete($property);

        return response()->json(['message' => 'Logement supprimé.'], 200);
    }
}
