<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    private function getData(Request $request)
    {
        $type = $request->get('type', 'kunjungan');
        $startDate = $request->get('start_date') ? Carbon::parse($request->start_date)->startOfDay() : Carbon::now()->startOfMonth();
        $endDate = $request->get('end_date') ? Carbon::parse($request->end_date)->endOfDay() : Carbon::now()->endOfDay();

        $data = [];

        if ($type === 'kunjungan') {
            $data = MedicalRecord::join('layanans', 'rekam_medis.layanan_id', '=', 'layanans.id')
                ->select(
                    DB::raw('DATE(rekam_medis.created_at) as date'),
                    'layanans.nama_layanan',
                    DB::raw('count(*) as total_visits')
                )
                ->whereBetween('rekam_medis.created_at', [$startDate, $endDate])
                ->groupBy('date', 'layanans.nama_layanan')
                ->orderBy('date', 'desc')
                ->get();
        } elseif ($type === 'penyakit') {
            $data = MedicalRecord::select('diagnosis', DB::raw('count(*) as count'))
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('diagnosis')
                ->orderByDesc('count')
                ->get();
        } elseif ($type === 'obat') {
            $data = DB::table('resep_obats')
                ->join('obats', 'resep_obats.obat_id', '=', 'obats.id')
                ->join('rekam_medis', 'resep_obats.rekam_medis_id', '=', 'rekam_medis.id')
                ->whereBetween('rekam_medis.created_at', [$startDate, $endDate])
                ->select('obats.nama_obat', 'obats.stok', DB::raw('sum(resep_obats.jumlah) as total_used'))
                ->groupBy('obats.id', 'obats.nama_obat', 'obats.stok')
                ->orderByDesc('total_used')
                ->get();
        } elseif ($type === 'keuangan') {
            $data = MedicalRecord::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total_visits'),
                DB::raw('sum(biaya) as revenue')
            )
                ->whereBetween('created_at', [$startDate, $endDate])
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();
        }

        return compact('data', 'type', 'startDate', 'endDate');
    }

    public function index(Request $request)
    {
        $result = $this->getData($request);
        return view('admin.reports.index', $result);
    }

    public function print(Request $request)
    {
        $result = $this->getData($request);
        return view('admin.reports.print', $result);
    }

    public function exportExcel(Request $request)
    {
        $result = $this->getData($request);
        $data = $result['data'];
        $type = $result['type'];
        $startDate = $result['startDate'];
        $endDate = $result['endDate'];

        $fileName = 'Laporan_' . ucfirst($type) . '_' . $startDate->format('Ymd') . '-' . $endDate->format('Ymd') . '.csv';

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = [];
        $callback = function () use ($data, $type) {
            $file = fopen('php://output', 'w');

            if ($type === 'kunjungan') {
                fputcsv($file, ['Tanggal', 'Jumlah Kunjungan', 'Jenis Layanan']);
                foreach ($data as $item) {
                    fputcsv($file, [
                        $item->date,
                        $item->total_visits,
                        $item->nama_layanan
                    ]);
                }
            } elseif ($type === 'penyakit') {
                fputcsv($file, ['No', 'Diagnosa', 'Jumlah Kasus']);
                foreach ($data as $index => $item) {
                    fputcsv($file, [
                        $index + 1,
                        $item->diagnosis,
                        $item->count
                    ]);
                }
            } elseif ($type === 'obat') {
                fputcsv($file, ['Nama Obat', 'Jumlah Terpakai', 'Sisa Stok']);
                foreach ($data as $item) {
                    fputcsv($file, [
                        $item->nama_obat,
                        $item->total_used,
                        $item->stok
                    ]);
                }
            } elseif ($type === 'keuangan') {
                fputcsv($file, ['Tanggal', 'Jumlah Kunjungan', 'Pendapatan']);
                foreach ($data as $item) {
                    fputcsv($file, [
                        $item->date,
                        $item->total_visits,
                        $item->revenue
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
