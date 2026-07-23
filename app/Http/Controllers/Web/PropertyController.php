<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function __construct(protected PropertyService $properties) {}

    public function index(): View
    {
        $properties = auth()->user()->isOwner()
            ? Property::where('owner_id', auth()->id())->with('images')->latest()->paginate(10)
            : Property::available()->with('images')->latest()->paginate(10);

        return view('properties.index', compact('properties'));
    }

    public function create(): View
    {
        $this->authorize('create', Property::class);

        return view('properties.create');
    }

    public function store(StorePropertyRequest $request): RedirectResponse
    {
        $property = $this->properties->create($request->user(), $request->validated());

        return redirect()->route('properties.show', $property)
            ->with('status', 'Logement créé avec succès.');
    }

    public function show(Property $property): View
    {
        $this->authorize('view', $property);

        $property->load('images', 'info', 'recommendations');

        return view('properties.show', compact('property'));
    }

    public function edit(Property $property): View
    {
        $this->authorize('update', $property);

        return view('properties.edit', compact('property'));
    }

    public function update(UpdatePropertyRequest $request, Property $property): RedirectResponse
    {
        $this->properties->update($property, $request->validated());

        return redirect()->route('properties.show', $property)
            ->with('status', 'Logement mis à jour.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $this->authorize('delete', $property);

        $this->properties->delete($property);

        return redirect()->route('properties.index')
            ->with('status', 'Logement supprimé.');
    }

    public function uploadImages(\Illuminate\Http\Request $request, Property $property): RedirectResponse
    {
        $this->authorize('update', $property);

        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'max:4096'],
        ]);

        $startPosition = $property->images()->max('position') + 1;

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('properties', 'public');
            $property->images()->create(['image' => $path, 'position' => $startPosition + $index]);
        }

        return back()->with('status', 'Images ajoutées.');
    }

    public function deleteImage(\App\Models\PropertyImage $propertyImage): RedirectResponse
    {
        $this->authorize('update', $propertyImage->property);

        Storage::disk('public')->delete($propertyImage->image);
        $property = $propertyImage->property;
        $propertyImage->delete();

        return redirect()->route('properties.show', $property)->with('status', 'Image supprimée.');
    }

    public function updateInfo(\Illuminate\Http\Request $request, Property $property): RedirectResponse
    {
        $this->authorize('update', $property);

        $data = $request->validate([
            'wifi_name' => ['nullable', 'string', 'max:100'],
            'wifi_password' => ['nullable', 'string', 'max:100'],
            'check_in' => ['nullable', 'date_format:H:i'],
            'check_out' => ['nullable', 'date_format:H:i'],
            'parking' => ['boolean'],
            'parking_info' => ['nullable', 'string'],
            'access_instructions' => ['nullable', 'string'],
            'house_rules' => ['nullable', 'string'],
        ]);

        $property->info()->updateOrCreate(['property_id' => $property->id], $data);

        return redirect()->route('properties.show', $property)->with('status', 'Informations mises à jour.');
    }

    public function storeRecommendation(\Illuminate\Http\Request $request, Property $property): RedirectResponse
    {
        $this->authorize('update', $property);

        $data = $request->validate([
            'category' => ['required', 'in:restaurant,cafe,beach,surf_school,taxi,pharmacy,hospital,supermarket,atm'],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $property->recommendations()->create($data);

        return back()->with('status', 'Recommandation ajoutée.');
    }

    public function destroyRecommendation(\App\Models\Recommendation $recommendation): RedirectResponse
    {
        $this->authorize('update', $recommendation->property);

        $property = $recommendation->property;
        $recommendation->delete();

        return redirect()->route('properties.show', $property)->with('status', 'Recommandation supprimée.');
    }
}