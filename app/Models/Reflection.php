<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reflection extends Model
{
    protected $table = 'reflections';

    protected $fillable = ['user_id', 'jawaban', 'refleksi', 'tingkat_ketepatan'];
}
