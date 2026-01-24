<?php

namespace App\Http\Controllers\Bidan;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Obat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class BidanMedicalRecordController extends Controller
{
    public function create(Request $request)
    {
        $patients = Patient::all();
        $medicines = Obat::where('stok', '>', 0)->get(); // Only show available medicines
        // Filter ACTIVE services only
        $services = \App\Models\Service::where('status', true)->orderBy('nama_layanan')->get();
        $pasien = null;

        if ($request->has('pasien_id')) {
            $pasien = Patient::find($request->pasien_id);
        }

        return view('bidan.medical-records.create', compact('patients', 'medicines', 'pasien', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'layanan_id' => 'required|exists:layanans,id',
            'keluhan_utama' => 'required|string',
            'tekanan_darah' => 'required|string',
            'nadi' => 'required|integer',
            'frekuensi_pernapasan' => 'required|integer',
            'berat_badan' => 'required|numeric',
            'suhu_tubuh' => 'required|numeric',
            'pemeriksaan_fisik' => 'nullable|string',
            'diagnosis' => 'required|string',
            'tindakan' => 'required|string',
            'biaya' => 'required|numeric',
            'alergi' => 'nullable|string',
            // Array validation for medicines
            'obat_id' => 'nullable|array',
            'obat_id.*' => 'required|exists:obats,id',
            'jumlah' => 'nullable|array',
            'jumlah.*' => 'required|integer|min:1',
            'dosis' => 'nullable|array',
            'dosis.*' => 'required|string',
        ], [
            'pasien_id.required' => 'Data pasien wajib dipilih.',
            'pasien_id.exists' => 'Data pasien yang dipilih tidak valid.',
            'layanan_id.required' => 'Jenis layanan wajib dipilih.',
            'layanan_id.exists' => 'Layanan yang dipilih tidak valid.',
            'keluhan_utama.required' => 'Keluhan utama wajib diisi.',
            'tekanan_darah.required' => 'Tekanan darah wajib diisi.',
            'nadi.required' => 'Nadi wajib diisi.',
            'frekuensi_pernapasan.required' => 'Frekuensi pernapasan wajib diisi.',
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'suhu_tubuh.required' => 'Suhu tubuh wajib diisi.',
            'diagnosis.required' => 'Diagnosis wajib diisi.',
            'tindakan.required' => 'Tindakan wajib diisi.',
            'biaya.required' => 'Biaya pemeriksaan wajib diisi.',
            'obat_id.*.required' => 'Nama obat wajib dipilih.',
            'obat_id.*.exists' => 'Obat yang dipilih tidak valid.',
            'jumlah.*.required' => 'Jumlah obat wajib diisi.',
            'jumlah.*.min' => 'Jumlah obat minimal 1.',
            'dosis.*.required' => 'Dosis obat wajib diisi.',
        ]);

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request, $validated) {
                // Update Patient Allergy
                if ($request->has('alergi')) {
                    $patient = Patient::find($validated['pasien_id']);
                    if ($patient) {
                        $patient->alergi = $validated['alergi'];
                        $patient->save();
                    }
                }

                // Create Medical Record
                $record = MedicalRecord::create([
                    'pasien_id' => $validated['pasien_id'],
                    'bidan_id' => Auth::id(),
                    'layanan_id' => $validated['layanan_id'],
                    'keluhan_utama' => $validated['keluhan_utama'],
                    'tekanan_darah' => $validated['tekanan_darah'],
                    'nadi' => $validated['nadi'],
                    'frekuensi_pernapasan' => $validated['frekuensi_pernapasan'],
                    'berat_badan' => $validated['berat_badan'],
                    'suhu_tubuh' => $validated['suhu_tubuh'],
                    'pemeriksaan_fisik' => $validated['pemeriksaan_fisik'],
                    'diagnosis' => $validated['diagnosis'],
                    'tindakan' => $validated['tindakan'],
                    'biaya' => $validated['biaya'],
                ]);

                // Process Medicines
                if ($request->has('obat_id') && is_array($request->obat_id)) {
                    foreach ($request->obat_id as $index => $obatId) {
                        // Strict Validations
                        if (!isset($request->jumlah[$index]) || !isset($request->dosis[$index])) {
                            continue;
                        }

                        $obat = Obat::lockForUpdate()->find($obatId); // Lock row to prevent race condition

                        if (!$obat) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'obat_id' => 'Data obat tidak ditemukan.'
                            ]);
                        }

                        $jumlah = (int) $request->jumlah[$index];
                        $dosis = $request->dosis[$index];

                        // VALIDASI STOK (RAISE ERROR IF INSUFFICIENT)
                        if ($obat->stok < $jumlah) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'resep' => "Stok obat {$obat->nama_obat} tersisa {$obat->stok}, jumlah diminta {$jumlah}. Transaksi dibatalkan."
                            ]);
                        }

                        // Decrement Stock
                        $obat->decrement('stok', $jumlah);

                        // Attach to Pivot
                        $record->medicines()->attach($obat->id, [
                            'jumlah' => $jumlah,
                            'dosis' => $dosis
                        ]);
                    }
                }

                // Log Activity
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => 'create',
                    'description' => "Bidan menambahkan rekam medis untuk pasien ID: {$validated['pasien_id']}",
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ]);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage())->withInput();
        }

        return redirect()->route('medical-records.latest')->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function latest(Request $request)
    {
        $query = MedicalRecord::with(['pasien', 'medicines'])->latest();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pasien', function ($sq) use ($search) {
                    $sq->where('nama_pasien', 'like', '%' . $search . '%');
                })
                    ->orWhere('diagnosis', 'like', '%' . $search . '%');
            });
        }

        $records = $query->paginate(10);
        return view('bidan.medical-records.latest', compact('records'));
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $medicalRecord->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'description' => "Bidan menghapus rekam medis dengan ID: {$medicalRecord->id}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        return redirect()->back()->with('success', 'Rekam medis berhasil dihapus.');
    }
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['pasien', 'medicines', 'bidan', 'layanan']);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'read',
            'description' => "Bidan melihat detail rekam medis dengan ID: {$medicalRecord->id}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        return view('bidan.medical-records.show', compact('medicalRecord'));
    }
}
