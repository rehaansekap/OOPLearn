<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fase2Jawaban extends Model
{
    protected $table = 'fase2_jawaban';

    protected $fillable = [
        'user_id',
        'pertemuan',
        'jawaban',
    ];

    protected $casts = [
        'jawaban' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
