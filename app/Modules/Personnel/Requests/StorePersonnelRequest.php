<?php

namespace App\Modules\Personnel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePersonnelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:personnel,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'nullable|string|max:100',
            'clinic_id' => 'nullable|exists:clinics,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Personel adı zorunludur.',
            'email.required' => 'E-posta zorunludur.',
            'email.email' => 'Geçerli bir e-posta giriniz.',
            'email.unique' => 'Bu e-posta zaten kullanımda.',
            'clinic_id.exists' => 'Seçilen klinik geçerli değil.',
        ];
    }
}
