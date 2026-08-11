<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skenario;
use App\Models\HasilSiswa;

class SimulasiController extends Controller
{
    /** Daftar skenario preset yang tersedia */
    public function index()
    {
        $skenarios = Skenario::where('aktif', true)->orderBy('urutan')->get();
        return view('simulasi.index', compact('skenarios'));
    }

    /**
     * Validasi kode Python dari sisi server sebelum dikirim ke Pyodide.
     * (Pyodide tetap menjalankan kode di sisi klien — endpoint ini hanya
     *  melakukan pemeriksaan keamanan dasar dan mencatat aktivitas.)
     */
    public function jalankan(Request $request)
    {
        $validated = $request->validate([
            'kode_python' => 'required|string|max:50000',
            'sesi_id'     => 'nullable|string|max:64',
        ]);

        $kode = $validated['kode_python'];

        // Pemeriksaan keamanan dasar — blokir perintah berbahaya
        $terlarang = ['import os', 'import subprocess', 'import sys', '__import__',
                      'open(', 'exec(', 'eval(', 'compile('];

        foreach ($terlarang as $pattern) {
            if (str_contains($kode, $pattern)) {
                return response()->json([
                    'boleh'  => false,
                    'pesan'  => "Kode mengandung perintah yang tidak diizinkan: `{$pattern}`.",
                ], 422);
            }
        }

        return response()->json([
            'boleh' => true,
            'pesan' => 'Kode lolos pemeriksaan. Simulasi siap dijalankan.',
        ]);
    }

    /** Simpan prediksi + refleksi hasil simulasi siswa */
    public function simpanHasil(Request $request)
    {
        $validated = $request->validate([
            'token'       => 'required|string|max:20|exists:hasil_siswas,token',
            'prediksi'    => 'nullable|array',
            'refleksi'    => 'nullable|string|max:10000',
            'jumlah_step' => 'nullable|integer',
            'durasi_detik'=> 'nullable|integer',
        ]);

        HasilSiswa::where('token', $validated['token'])->update([
            'prediksi_json' => json_encode($validated['prediksi'] ?? []),
            'refleksi'      => $validated['refleksi'] ?? null,
            'jumlah_step'   => $validated['jumlah_step'] ?? 0,
            'durasi_detik'  => $validated['durasi_detik'] ?? 0,
            'selesai_at'    => now(),
        ]);

        return response()->json(['success' => true]);
    }

    /** Rekap hasil seluruh siswa (untuk guru/peneliti) */
    public function rekap()
    {
        $hasil = HasilSiswa::whereNotNull('selesai_at')
            ->orderByDesc('selesai_at')
            ->paginate(25);

        return view('simulasi.rekap', compact('hasil'));
    }
}
