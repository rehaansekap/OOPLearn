<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\LearningProgress;

class EnsureFaseUnlocked
{
    public function handle($request, Closure $next, $pertemuan, $fase)
    {
        $progress = LearningProgress::firstOrCreate(['user_id' => Auth::id()]);

        if (!$progress->isFaseUnlocked((int) $pertemuan, (int) $fase)) {
            $pesan = $fase == 1
                ? "Selesaikan seluruh Pertemuan " . ($pertemuan - 1) . " dulu sebelum lanjut ke Pertemuan {$pertemuan}."
                : "Selesaikan Fase " . ($fase - 1) . " dulu sebelum lanjut ke Fase {$fase}.";
            return redirect()->route('dashboard.siswa')->with('lock_message', $pesan);
        }

        return $next($request);
    }
}
