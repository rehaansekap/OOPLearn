<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skenario;
use App\Models\HasilSiswa;
use Illuminate\Support\Str;

class BlueprintController extends Controller
{
    /** Halaman pemilihan konsep (beranda ICS). */
    public function home()
    {
        return view('home');
    }

    /** Halaman simulasi Enkapsulasi (juga dipakai untuk Fase 4 – Aplikasi). */
    public function enkapsulasi()
    {
        $fromFase = request()->routeIs('fase4') ? 4 : null;
        return view('blueprint.builder', [
            'konsep'     => 'enkapsulasi',
            'fromFase'   => $fromFase,
            'backRoute'  => $fromFase ? route('dashboard.siswa') : route('simulasi.index'),
            'backLabel'  => $fromFase ? '← Dashboard' : '← Beranda',
            'nextRoute'  => $fromFase ? route('fase4.complete') : null,
            'nextLabel'  => 'Lanjut ke Fase 5 – Refleksi',
        ]);
    }

    /** Halaman simulasi Gabungan Enkapsulasi + Inheritance (Fase 4 – Aplikasi P3). */
    public function gabungan()
    {
        return view('blueprint.builder', [
            'konsep'     => 'gabungan',
            'fromFase'   => 4,
            'backRoute'  => route('p3.fase3'),
            'backLabel'  => '← Fase 3 – Penstrukturan',
            'nextRoute'  => route('p3.fase4.complete'),
            'nextLabel'  => 'Lanjut ke Fase 5 – Refleksi',
        ]);
    }

    /** Halaman simulasi Inheritance / Pewarisan (juga dipakai untuk Fase 4 – Aplikasi P2). */
    public function inheritance()
    {
        $fromFase = request()->routeIs('p2.fase4') ? 4 : null;
        return view('blueprint.builder', [
            'konsep'     => 'inheritance',
            'fromFase'   => $fromFase,
            'backRoute'  => $fromFase ? route('p2.fase3') : route('simulasi.index'),
            'backLabel'  => $fromFase ? '← Fase 3 – Penstrukturan' : '← Beranda',
            'nextRoute'  => $fromFase ? route('p2.fase4.complete') : null,
            'nextLabel'  => 'Lanjut ke Fase 5 – Refleksi',
        ]);
    }

    /**
     * Tampilkan halaman Blueprint Builder (Phase 1 → 2 → 3).
     * Semua logika visualisasi berjalan di sisi klien (Pyodide).
     */
    public function builder(Request $request)
    {
        // Preset skenario untuk quick-load
        $presets = Skenario::where('aktif', true)
            ->orderBy('urutan')
            ->get(['id', 'judul', 'deskripsi', 'blueprint_json', 'kode_python']);

        return view('blueprint.builder', compact('presets'));
    }

    /**
     * Simpan blueprint siswa ke database dan kembalikan share token.
     * Dipanggil via AJAX.
     */
    public function simpan(Request $request)
    {
        $validated = $request->validate([
            'blueprint_json' => 'required|json',
            'kode_python'    => 'required|string|max:50000',
            'nama_siswa'     => 'nullable|string|max:100',
            'prediksi_awal'  => 'nullable|string|max:5000',
        ]);

        $token = Str::random(12);

        HasilSiswa::create([
            'token'          => $token,
            'nama_siswa'     => $validated['nama_siswa'] ?? 'Anonim',
            'blueprint_json' => $validated['blueprint_json'],
            'kode_python'    => $validated['kode_python'],
            'prediksi_awal'  => $validated['prediksi_awal'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'token'   => $token,
            'url'     => route('blueprint.muat', $token),
        ]);
    }

    /**
     * Muat blueprint berdasarkan token (share link).
     */
    public function muat(string $token)
    {
        $hasil = HasilSiswa::where('token', $token)->firstOrFail();

        return response()->json([
            'blueprint_json' => $hasil->blueprint_json,
            'kode_python'    => $hasil->kode_python,
            'prediksi_awal'  => $hasil->prediksi_awal,
        ]);
    }
}
