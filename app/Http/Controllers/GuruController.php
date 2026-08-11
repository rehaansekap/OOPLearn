<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSetting;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    /**
     * Stream seluruh data nilai siswa sebagai file CSV untuk diunduh.
     * Kolom: Nama Siswa | Pretest | Posttest | Selisih | Fase 1–5
     */
    public function exportNilai()
    {
        $siswas = User::where('role', 'siswa')
            ->with(['learningProgress', 'score'])
            ->orderBy('name')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="Rekap_Nilai_OOP.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($siswas) {
            $handle = fopen('php://output', 'w');
            fputs($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Nama Siswa', 'Pretest', 'Posttest', 'Selisih',
                'Fase 1', 'Fase 2', 'Fase 3', 'Fase 4', 'Fase 5',
            ]);
            foreach ($siswas as $siswa) {
                $sc   = $siswa->score;
                $lp   = $siswa->learningProgress;
                $pre  = $sc?->pretest  ?? '-';
                $post = $sc?->posttest ?? '-';
                $gain = is_numeric($pre) && is_numeric($post) ? ($post - $pre) : '-';
                fputcsv($handle, [
                    $siswa->name, $pre, $post, $gain,
                    $lp?->fase1 ? 'Selesai' : 'Belum',
                    $lp?->fase2 ? 'Selesai' : 'Belum',
                    $lp?->fase3 ? 'Selesai' : 'Belum',
                    $lp?->fase4 ? 'Selesai' : 'Belum',
                    $lp?->fase5 ? 'Selesai' : 'Belum',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    // ── Assessment Management ─────────────────────────────────────────────────

    public function storeQuestion(Request $request)
    {
        $data = $request->validate([
            'type'     => 'required|in:pretest,posttest',
            'question' => 'required|string|max:10000',
            'option_a' => 'required|string|max:5000',
            'option_b' => 'required|string|max:5000',
            'option_c' => 'required|string|max:5000',
            'option_d' => 'required|string|max:5000',
            'answer'   => 'required|in:A,B,C,D',
        ]);

        $next = AssessmentQuestion::where('type', $data['type'])->max('number') + 1;

        AssessmentQuestion::create(array_merge($data, ['number' => $next]));

        return redirect()->route('dashboard.guru', ['section' => 'assessment', 'tab' => $data['type']])
            ->with('assessment_success', 'Soal berhasil ditambahkan.');
    }

    public function updateQuestion(Request $request, AssessmentQuestion $question)
    {
        $data = $request->validate([
            'question' => 'required|string|max:10000',
            'option_a' => 'required|string|max:5000',
            'option_b' => 'required|string|max:5000',
            'option_c' => 'required|string|max:5000',
            'option_d' => 'required|string|max:5000',
            'answer'   => 'required|in:A,B,C,D',
        ]);

        $question->update($data);

        return redirect()->route('dashboard.guru', ['section' => 'assessment', 'tab' => $question->type])
            ->with('assessment_success', 'Soal berhasil diperbarui.');
    }

    public function destroyQuestion(AssessmentQuestion $question)
    {
        $type = $question->type;
        $question->delete();

        // Re-number remaining questions sequentially
        AssessmentQuestion::where('type', $type)
            ->orderBy('number')
            ->get()
            ->each(function ($q, $idx) {
                $q->update(['number' => $idx + 1]);
            });

        return redirect()->route('dashboard.guru', ['section' => 'assessment', 'tab' => $type])
            ->with('assessment_success', 'Soal berhasil dihapus.');
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'type'       => 'required|in:pretest,posttest',
            'time_limit' => 'required|integer|min:1|max:180',
        ]);

        AssessmentSetting::updateOrCreate(
            ['type' => $data['type']],
            ['time_limit' => $data['time_limit']]
        );

        return redirect()->route('dashboard.guru', ['section' => 'assessment', 'tab' => $data['type']])
            ->with('assessment_success', 'Batas waktu berhasil diperbarui.');
    }
}
