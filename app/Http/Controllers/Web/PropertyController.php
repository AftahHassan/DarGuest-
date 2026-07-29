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
        $user = auth()->user();
        $isOwner = $user->isOwner();

        $properties = $isOwner
            ? Property::where('owner_id', $user->id)
            : Property::available();

        $properties = $properties->with('images');

        if ($status = request('status')) {
            $properties->where('status', $status);
        }

        if ($search = request('search')) {
            $properties->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%");
            });
        }

        if ($city = request('city')) {
            $properties->where('city', $city);
        }

        if ($priceMin = request('price_min')) {
            $properties->where('price_per_night', '>=', (float) $priceMin);
        }

        if ($priceMax = request('price_max')) {
            $properties->where('price_per_night', '<=', (float) $priceMax);
        }

        $sort = request('sort');
        $properties->when($sort, function ($q, $sort) {
            return match ($sort) {
                'price_asc' => $q->orderBy('price_per_night'),
                'price_desc' => $q->orderBy('price_per_night', 'desc'),
                'name_asc' => $q->orderBy('title'),
                'name_desc' => $q->orderBy('title', 'desc'),
                'date_asc' => $q->oldest(),
                default => $q->latest(),
            };
        }, fn ($q) => $q->latest());

        $cities = $isOwner
            ? Property::where('owner_id', $user->id)->select('city')->distinct()->orderBy('city')->pluck('city')
            : Property::available()->select('city')->distinct()->orderBy('city')->pluck('city');

        $totalCount = $isOwner
            ? Property::where('owner_id', $user->id)->count()
            : Property::available()->count();

        $properties = $properties->paginate(12);

        return view('properties.index', compact('properties', 'cities', 'totalCount'));
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

        if ($editId = $request->input('edit_id')) {
            $reco = $property->recommendations()->findOrFail($editId);
            $reco->update($data);
            return back()->with('status', 'Recommandation mise à jour.');
        }

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