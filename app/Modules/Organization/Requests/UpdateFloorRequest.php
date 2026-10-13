<?php

namespace App\Modules\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFloorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id' => 'required|exists:buildings,id',
            'name'        => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'building_id.required' => 'Bina seçimi zorunludur.',
            'building_id.exists'   => 'Seçilen bina geçerli değil.',
            'name.required'        => 'Kat adı zorunludur.',
            'name.max'             => 'Kat adı en fazla 255 karakter olabilir.',
        ];
    }
}
