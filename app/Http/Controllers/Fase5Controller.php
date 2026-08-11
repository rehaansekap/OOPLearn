<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reflection;
use App\Models\LearningProgress;

class Fase5Controller extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'pertemuan'         => 'nullable|in:1,2,3',
            'jawaban'           => 'required|in:A,B,C,D,E',
            'refleksi'          => 'required|string|max:2000',
            'tingkat_ketepatan' => 'required|in:sangat_berbeda,sebagian_tepat,sangat_tepat',
        ]);

        // Default ke Pertemuan 1 kalau field 'pertemuan' tidak dikirim —
        // supaya form fase5.blade.php Pertemuan 1 yang sudah ada tetap jalan
        // tanpa perlu diubah.
        $pertemuan = (int) ($data['pertemuan'] ?? 1);

        Reflection::updateOrCreate(
            ['user_id' => Auth::id(), 'pertemuan' => $pertemuan],
            [
                'jawaban'           => $request->jawaban,
                'refleksi'          => $request->refleksi,
                'tingkat_ketepatan' => $request->tingkat_ketepatan,
            ]
        );

        $progress = LearningProgress::firstOrCreate(['user_id' => Auth::id()]);

        if ($pertemuan === 1) {
            // Perilaku asli Pertemuan 1 — tidak diubah.
            $progress->fase5 = true;
            $progress->save();

            return redirect()->route('grade')
                ->with('success', 'Refleksi berhasil disimpan!');
        }

        // Pertemuan 2/3 — set seluruh Fase 1-5 milik pertemuan itu (sama seperti
        // route p2.fase5.complete / p3.fase5.complete lama sebelum diganti ke sini).
        $prefix = "p{$pertemuan}_";
        for ($f = 1; $f <= 5; $f++) {
            $progress->{$prefix . "fase{$f}"} = true;
        }
        $progress->save();

        return redirect()->route('dashboard.siswa')
            ->with('success', 'Refleksi berhasil disimpan!');
    }
}
