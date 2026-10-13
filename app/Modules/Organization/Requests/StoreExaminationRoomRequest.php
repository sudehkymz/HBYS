<?php

namespace App\Modules\Organization\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExaminationRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'poliklinik_id' => 'required|exists:polikliniks,id',
            'name'          => 'required|string|max:255',
            'capacity'      => 'required|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'poliklinik_id.required' => 'Poliklinik seçimi zorunludur.',
            'poliklinik_id.exists'   => 'Seçilen poliklinik geçerli değil.',
            'name.required'          => 'Muayene odası adı zorunludur.',
            'name.max'               => 'Oda adı en fazla 255 karakter olabilir.',
            'capacity.required'      => 'Kapasite girilmesi zorunludur.',
            'capacity.integer'       => 'Kapasite tam sayı olmalıdır.',
            'capacity.min'           => 'Kapasite en az 1 olmalıdır.',
        ];
    }
}
