<?php

namespace App\Modules\Patient\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'national_id' => 'required|digits:11|unique:patients,national_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:1000',
            'blood_type' => 'nullable|string|max:10',
            'allergies' => 'nullable|string|max:1000',
            'chronic_conditions' => 'nullable|string|max:1000',
            'emergency_contact' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'national_id.required' => 'T.C. Kimlik Numarası zorunludur.',
            'national_id.digits' => 'T.C. Kimlik Numarası 11 haneli olmalıdır.',
            'national_id.unique' => 'Bu T.C. Kimlik Numarası ile kayıtlı başka bir hasta bulunmaktadır.',
            'first_name.required' => 'Hasta adı zorunludur.',
            'last_name.required' => 'Hasta soyadı zorunludur.',
            'birth_date.required' => 'Doğum tarihi zorunludur.',
            'birth_date.before' => 'Doğum tarihi bugünden önce olmalıdır.',
            'gender.required' => 'Cinsiyet seçimi zorunludur.',
            'gender.in' => 'Geçerli bir cinsiyet seçiniz.',
        ];
    }
}
