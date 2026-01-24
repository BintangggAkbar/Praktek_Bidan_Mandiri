<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class AdminMedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['pasien', 'bidan', 'layanan'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('pasien', function ($q) use ($search) {
                $q->where('nama_pasien', 'like', '%' . $search . '%');
            })->orWhereHas('bidan', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', '%' . $search . '%');
            });
        }

        $medicalRecords = $query->paginate(10);
        return view('admin.medical-records.index', compact('medicalRecords'));
    }

    public function show(MedicalRecord $medicalRecord)
    {
        // Ensure relationships are loaded
        $medicalRecord->load(['pasien', 'bidan', 'layanan', 'medicines']);

        // Log View Access (Sensitive Data)
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'read',
            'description' => "Admin melihat detail rekam medis dengan ID: {$medicalRecord->id}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return view('admin.medical-records.show', compact('medicalRecord'));
    }
}
