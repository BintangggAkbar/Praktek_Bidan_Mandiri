<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Obat;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ActivityLog;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBidan = User::where('role', 'bidan')->count();
        $totalPasien = Patient::count();
        $totalObat = Obat::count();
        $obatHampirHabis = Obat::where('stok', '<=', 10)->get();

        $pendapatanBulanIni = MedicalRecord::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('biaya');

        $activityLogs = ActivityLog::with('user')->latest()->take(10)->get();

        // DATA GRAFIK 7 HARI TERAKHIR
        $chartData = MedicalRecord::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as count')
        )
            ->whereDate('created_at', '>=', Carbon::today()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Siapkan 7 hari terakhir (TERMASUK hari ini)
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i)->format('Y-m-d');
            $dates[$date] = 0;
        }

        // Isi data kunjungan jika ada
        foreach ($chartData as $data) {
            if (isset($dates[$data->date])) {
                $dates[$data->date] = $data->count;
            }
        }

        ksort($dates);

        // LABEL GRAFIK (HARI + TANGGAL)
        Carbon::setLocale('id');

        $chartLabels = [];
        $chartValues = [];

        foreach ($dates as $date => $count) {
            $carbonDate = Carbon::parse($date);

            // Contoh: Senin (22 Jan)
            $chartLabels[] = $carbonDate->translatedFormat('l (d M)');
            $chartValues[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalBidan',
            'totalPasien',
            'totalObat',
            'obatHampirHabis',
            'pendapatanBulanIni',
            'chartLabels',
            'chartValues',
            'activityLogs'
        ));
    }
}
