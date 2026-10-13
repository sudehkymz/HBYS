<?php

namespace App\Modules\Identity\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', 'in:admin,physician,nurse,receptionist,pharmacist,lab_technician,radiology_technician,manager'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'Ad Soyad zorunludur.',
            'email.required'     => 'E-posta adresi zorunludur.',
            'email.email'        => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique'       => 'Bu e-posta adresi zaten kayıtlı.',
            'role.required'      => 'Rol seçimi zorunludur.',
            'role.in'            => 'Geçersiz bir rol seçildi.',
            'password.required'  => 'Şifre zorunludur.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
            'password.min'       => 'Şifre en az 8 karakter olmalıdır.',
        ];
    }
}
