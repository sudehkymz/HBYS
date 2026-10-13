<?php

namespace App\Modules\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Bina adı zorunludur.',
            'name.max'      => 'Bina adı en fazla 255 karakter olabilir.',
            'address.max'   => 'Adres en fazla 500 karakter olabilir.',
        ];
    }
}
