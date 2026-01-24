<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class BidanMedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Obat::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', '%' . $search . '%')
                    ->orWhere('kategori_obat', 'like', '%' . $search . '%');
            });
        }

        $medicines = $query->paginate(10);
        return view('bidan.medicines.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bidan.medicines.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'dosis' => 'required|string',
            'kategori_obat' => 'required|string',
            'bentuk_sediaan' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        Obat::create($validated);

        return redirect()->route('medicines.index')->with('success', 'Obat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $medicine)
    {
        return view('bidan.medicines.edit', ['medicine' => $medicine]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Obat $medicine)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'dosis' => 'required|string',
            'kategori_obat' => 'required|string',
            'bentuk_sediaan' => 'required|string',
            'stok' => 'required|integer',
            'satuan' => 'required|string',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicines.index')->with('success', 'Obat berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Obat $medicine)
    {
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Obat berhasil dihapus.');
    }
}
