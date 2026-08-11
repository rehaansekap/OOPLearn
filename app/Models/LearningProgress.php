<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningProgress extends Model
{
    protected $table = 'learning_progress';

    protected $fillable = [
        'user_id',
        // Pertemuan 1 – Enkapsulasi
        'fase1','fase2','fase3','fase4','fase5',
        // Pertemuan 2 – Inheritance
        'p2_fase1','p2_fase2','p2_fase3','p2_fase4','p2_fase5',
        // Pertemuan 3 – Proyek Akhir
        'p3_fase1','p3_fase2','p3_fase3','p3_fase4','p3_fase5',
        // Tracking "sudah buka halaman Materi" per pertemuan (gerbang toolbox Fase 3)
        'materi_dibuka_1','materi_dibuka_2','materi_dibuka_3',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function score()
    {
        return $this->hasOne(StudentScore::class, 'user_id', 'user_id');
    }

    public function isFaseUnlocked(int $pertemuan, int $fase): bool
    {
        if ($fase === 1 && $pertemuan > 1) {
            return $this->isPertemuanSelesai($pertemuan - 1);
        }
        if ($fase > 1) {
            return (bool) $this->{$this->faseField($pertemuan, $fase - 1)};
        }
        return true;
    }

    public function isPertemuanSelesai(int $pertemuan): bool
    {
        for ($f = 1; $f <= 5; $f++) {
            if (!(bool) $this->{$this->faseField($pertemuan, $f)}) return false;
        }
        return true;
    }

    private function faseField(int $pertemuan, int $fase): string
    {
        return $pertemuan === 1 ? "fase{$fase}" : "p{$pertemuan}_fase{$fase}";
    }

    public function pretestSelesai(): bool
    {
        return $this->score !== null && $this->score->pretest !== null;
    }

    public function semuaPertemuanSelesai(): bool
    {
        return $this->isPertemuanSelesai(1) && $this->isPertemuanSelesai(2) && $this->isPertemuanSelesai(3);
    }

    public function pertemuanAktif(): int
    {
        if (!$this->isPertemuanSelesai(1)) return 1;
        if (!$this->isPertemuanSelesai(2)) return 2;
        return 3;
    }

    public function materiUnlocked(): bool
    {
        $p = $this->pertemuanAktif();
        return (bool) $this->{$this->faseField($p, 1)} && (bool) $this->{$this->faseField($p, 2)};
    }

    public function materiDibuka(int $pertemuan): bool
    {
        return (bool) $this->{"materi_dibuka_{$pertemuan}"};
    }

    public function tandaiMateriDibuka(int $pertemuan): void
    {
        $this->{"materi_dibuka_{$pertemuan}"} = true;
        $this->save();
    }

    public function nextIncompleteFase(int $pertemuan): int
    {
        for ($f = 1; $f <= 5; $f++) {
            if (!(bool) $this->{$this->faseField($pertemuan, $f)}) return $f;
        }
        return 5;
    }
}
