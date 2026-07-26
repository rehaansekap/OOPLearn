<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSetting;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        if (AssessmentQuestion::exists()) {
            return;
        }

        $now = now();

        AssessmentQuestion::insert([
            // ── Pretest ──────────────────────────────────────────────
            ['type'=>'pretest','number'=>1,
             'question'=>'Apa yang dimaksud class?',
             'option_a'=>'Variabel','option_b'=>'Blueprint Object','option_c'=>'Method','option_d'=>'Operator',
             'answer'=>'B','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'pretest','number'=>2,
             'question'=>'Object adalah?',
             'option_a'=>'Instansiasi Class','option_b'=>'Variabel','option_c'=>'Function','option_d'=>'Array',
             'answer'=>'A','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'pretest','number'=>3,
             'question'=>'Enkapsulasi bertujuan?',
             'option_a'=>'Mempercepat Program','option_b'=>'Menambah RAM','option_c'=>'Melindungi Data','option_d'=>'Membuat File',
             'answer'=>'C','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'pretest','number'=>4,
             'question'=>'Inheritance berarti?',
             'option_a'=>'Pengulangan','option_b'=>'Seleksi','option_c'=>'Input','option_d'=>'Pewarisan',
             'answer'=>'D','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'pretest','number'=>5,
             'question'=>'Access Modifier private digunakan untuk?',
             'option_a'=>'Semua Class','option_b'=>'Membatasi Akses Data','option_c'=>'Membuat Object','option_d'=>'Menghapus Class',
             'answer'=>'B','created_at'=>$now,'updated_at'=>$now],

            // ── Posttest ─────────────────────────────────────────────
            ['type'=>'posttest','number'=>1,
             'question'=>'Apa yang dimaksud class?',
             'option_a'=>'Variabel','option_b'=>'Blueprint Object','option_c'=>'Method','option_d'=>'Operator',
             'answer'=>'B','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'posttest','number'=>2,
             'question'=>'Object adalah?',
             'option_a'=>'Instansiasi Class','option_b'=>'Variabel','option_c'=>'Function','option_d'=>'Array',
             'answer'=>'A','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'posttest','number'=>3,
             'question'=>'Enkapsulasi bertujuan?',
             'option_a'=>'Mempercepat Program','option_b'=>'Menambah RAM','option_c'=>'Melindungi Data','option_d'=>'Membuat File',
             'answer'=>'C','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'posttest','number'=>4,
             'question'=>'Inheritance berarti?',
             'option_a'=>'Pengulangan','option_b'=>'Seleksi','option_c'=>'Input','option_d'=>'Pewarisan',
             'answer'=>'D','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'posttest','number'=>5,
             'question'=>'Access Modifier private digunakan untuk?',
             'option_a'=>'Semua Class','option_b'=>'Membatasi Akses Data','option_c'=>'Membuat Object','option_d'=>'Menghapus Class',
             'answer'=>'B','created_at'=>$now,'updated_at'=>$now],
        ]);

        AssessmentSetting::insert([
            ['type'=>'pretest',  'time_limit'=>20, 'created_at'=>$now, 'updated_at'=>$now],
            ['type'=>'posttest', 'time_limit'=>20, 'created_at'=>$now, 'updated_at'=>$now],
        ]);
    }
}
