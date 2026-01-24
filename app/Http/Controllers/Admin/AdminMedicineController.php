<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class AdminMedicineController extends Controller
{
    public function index(Request $request)
    {
        $query = Obat::latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_obat', 'like', '%' . $search . '%');
        }

        $medicines = $query->paginate(10);

        return view('admin.medicines.index', compact('medicines'));
    }
}
