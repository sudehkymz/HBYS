<?php

namespace App\Modules\Personnel\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable|string|max:20',
            'specialty' => 'required|string|max:255',
            'clinic_id' => 'nullable|exists:clinics,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Doktor adı zorunludur.',
            'email.required' => 'E-posta zorunludur.',
            'email.email' => 'Geçerli bir e-posta giriniz.',
            'email.unique' => 'Bu e-posta zaten kullanımda.',
            'specialty.required' => 'Uzmanlık alanı zorunludur.',
            'clinic_id.exists' => 'Seçilen klinik geçerli değil.',
        ];
    }
}
