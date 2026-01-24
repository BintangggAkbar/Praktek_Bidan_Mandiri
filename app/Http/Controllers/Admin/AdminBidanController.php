<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminBidanController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'bidan')->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        $bidans = $query->paginate(10);
        return view('admin.bidans.index', compact('bidans'));
    }

    public function create()
    {
        return view('admin.bidans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
            'password_confirmation' => 'required|same:password',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $validated['role'] = 'bidan';
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.bidans.index')->with('success', 'Bidan berhasil ditambahkan.');
    }

    public function show(User $bidan)
    {
        return view('admin.bidans.show', compact('bidan'));
    }

    public function edit(User $bidan)
    {
        // Ensure only bidan role can be edited here if needed, or by type hinting
        return view('admin.bidans.edit', compact('bidan'));
    }

    public function update(Request $request, User $bidan)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $bidan->id,
            'email' => 'required|email|unique:users,email,' . $bidan->id,
            'password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()], // Nullable for update
            'password_confirmation' => 'nullable|same:password',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:500',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $data = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'status' => $validated['status'],
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $bidan->update($data);

        return redirect()->route('admin.bidans.index')->with('success', 'Data bidan berhasil diperbarui.');
    }

    public function destroy(User $bidan)
    {
        $bidan->delete();
        return redirect()->route('admin.bidans.index')->with('success', 'Bidan berhasil dihapus.');
    }
}
