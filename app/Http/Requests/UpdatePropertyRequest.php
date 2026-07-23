<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('property'));
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'city' => ['sometimes', 'required', 'string', 'max:100'],
            'address' => ['sometimes', 'required', 'string', 'max:255'],
            'price_per_night' => ['sometimes', 'required', 'numeric', 'min:0'],
            'capacity' => ['sometimes', 'required', 'integer', 'min:1'],
            'bedrooms' => ['sometimes', 'required', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'required', 'integer', 'min:0'],
            'status' => ['sometimes', 'in:available,unavailable,maintenance'],
        ];
    }
}