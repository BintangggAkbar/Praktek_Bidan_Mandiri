<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profile
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update data profile user
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')->with('success', 'Data profil berhasil diperbarui.');
    }

    /**
     * Update password user
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('profile.edit')->with('success', 'Password berhasil diubah.');
    }
}
