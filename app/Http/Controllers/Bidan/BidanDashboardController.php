<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Obat;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BidanDashboardController extends Controller
{
    public function index()
    {
        // Notifikasi Obat Hampir Habis
        $obatHampirHabis = Obat::where('stok', '<=', 10)->get();

        // Total Pasien
        $totalPasien = Patient::count();

        // Pasien Aktif (30 Hari Terakhir)
        $pasienAktif = Patient::whereHas('medicalRecords', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(30));
        })->count();

        // Total Rekam Medis (Filtered by login bidan)
        $totalRekamMedis = MedicalRecord::where('bidan_id', Auth::id())->count();

        // Kunjungan Hari Ini (Global/Clinic wide check-in today)
        $kunjunganHariIni = MedicalRecord::whereDate('created_at', Carbon::today())->count();

        // Kunjungan Terbaru (5 latest visits)
        $latestVisits = MedicalRecord::with(['pasien', 'layanan'])
            ->latest()
            ->take(5)
            ->get();

        return view('bidan.dashboard', compact(
            'obatHampirHabis',
            'totalPasien',
            'pasienAktif',
            'totalRekamMedis',
            'kunjunganHariIni',
            'latestVisits'
        ));
    }
}
