<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Menampilkan halaman profil
    public function edit(): View
    {
        return view('profile.edit');
    }

    //Mengupdate data profil
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = $request->validated();

        // Menyimpan hasil crop foto profil
        if ($request->filled('cropped_foto')) {
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            $imageData = preg_replace('/^data:image\/\w+;base64,/', '', $request->cropped_foto);
            $imageData = str_replace(' ', '+', $imageData);

            $fileName = 'foto-user/' . uniqid('foto_', true) . '.png';

            Storage::disk('public')->put($fileName, base64_decode($imageData));

            $data['foto'] = $fileName;
        }

        // Mengosongkan NIM jika user bukan mahasiswa
        if ($user->role !== 'mahasiswa') {
            $data['nim'] = $request->nim ?: null;
        }

        // Mengupdate password jika password baru diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        unset($data['current_password'], $data['password_confirmation'], $data['cropped_foto']);

        $user->update($data);

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Profil berhasil diperbarui.');
    }

    //Mengarahkan kembali jika fitur hapus akun belum digunakan
    public function destroy(): RedirectResponse
    {
        return redirect()->route('profile.edit');
    }
}
