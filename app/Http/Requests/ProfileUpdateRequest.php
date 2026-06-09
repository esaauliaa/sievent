<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = $this->user();

        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s.\']+$/',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id_user, 'id_user'),
            ],

            'nim' => [
                Rule::requiredIf($user->role === 'mahasiswa'),
                'nullable',
                'digits:12',
                Rule::unique('users', 'nim')->ignore($user->id_user, 'id_user'),
            ],

            'no_telpon' => [
                'required',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:15',
            ],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'cropped_foto' => [
                'nullable',
                'string',
            ],

            'current_password' => [
                'nullable',
                'required_with:password',
                'current_password',
            ],

            'password' => [
                'nullable',
                'confirmed',
                Password::min(8),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // Nama
            'nama.required' => 'Nama wajib diisi.',
            'nama.string' => 'Nama harus berupa teks.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'nama.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, dan tanda petik.',

            // Email
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',

            // NIM
            'nim.required' => 'NIM wajib diisi untuk mahasiswa.',
            'nim.digits' => 'NIM harus terdiri dari 12 digit angka.',
            'nim.unique' => 'NIM sudah digunakan.',

            // Nomor telepon
            'no_telpon.required' => 'Nomor telepon wajib diisi.',
            'no_telpon.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telpon.min' => 'Nomor telepon minimal 10 digit.',
            'no_telpon.max' => 'Nomor telepon maksimal 15 digit.',

            // Foto
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',

            // Foto hasil crop
            'cropped_foto.string' => 'Format hasil crop foto tidak valid.',

            // Password
            'current_password.required_with' => 'Password lama wajib diisi jika ingin mengganti password.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
            'password.min' => 'Password baru minimal 8 karakter.',
        ];
    }
}
