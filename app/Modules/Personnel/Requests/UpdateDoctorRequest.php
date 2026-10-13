<?php

namespace App\Modules\Personnel\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor') ? $this->route('doctor')->id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('doctors', 'email')->ignore($doctorId),
            ],
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
