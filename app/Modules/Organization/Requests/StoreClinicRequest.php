<?php

namespace App\Modules\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClinicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'floor_id' => 'required|exists:floors,id',
            'name'     => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'floor_id.required' => 'Kat seçimi zorunludur.',
            'floor_id.exists'   => 'Seçilen kat geçerli değil.',
            'name.required'     => 'Klinik adı zorunludur.',
            'name.max'          => 'Klinik adı en fazla 255 karakter olabilir.',
        ];
    }
}
