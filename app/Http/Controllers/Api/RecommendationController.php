<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecommendationRequest;
use App\Http\Requests\UpdateRecommendationRequest;
use App\Http\Resources\RecommendationResource;
use App\Models\Property;
use App\Models\Recommendation;

class RecommendationController extends Controller
{
    public function index(Property $property)
    {
        return RecommendationResource::collection($property->recommendations);
    }

    public function store(StoreRecommendationRequest $request, Property $property)
    {
        $recommendation = $property->recommendations()->create($request->validated());

        return new RecommendationResource($recommendation);
    }

    public function update(UpdateRecommendationRequest $request, Recommendation $recommendation)
    {
        $recommendation->update($request->validated());

        return new RecommendationResource($recommendation->fresh());
    }

    public function destroy(Recommendation $recommendation)
    {
        $this->authorize('delete', $recommendation);

        $recommendation->delete();

        return response()->json(['message' => 'Recommandation supprimée.'], 200);
    }
}