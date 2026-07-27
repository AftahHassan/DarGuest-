<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservationStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('updateStatus', $this->route('reservation'));
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,confirmed,cancelled,completed'],
        ];
    }
}