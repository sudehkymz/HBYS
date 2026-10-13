<?php

namespace App\Modules\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePoliklinikRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'clinic_id' => 'required|exists:clinics,id',
            'name'      => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'clinic_id.required' => 'Klinik seçimi zorunludur.',
            'clinic_id.exists'   => 'Seçilen klinik geçerli değil.',
            'name.required'      => 'Poliklinik adı zorunludur.',
            'name.max'           => 'Poliklinik adı en fazla 255 karakter olabilir.',
        ];
    }
}
