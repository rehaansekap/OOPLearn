<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentScore;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSetting;
use App\Models\LearningProgress;

class AssessmentController extends Controller
{
    public function showPretest()
    {
        return view('pretest', [
            'questions' => AssessmentQuestion::where('type', 'pretest')->orderBy('number')->get(),
            'timeLimit' => AssessmentSetting::timeLimitFor('pretest'),
        ]);
    }

    public function showPosttest()
    {
        $progress = LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        if (!$progress->semuaPertemuanSelesai()) {
            return redirect()->route('dashboard.siswa')
                ->with('lock_message', 'Selesaikan seluruh 3 Pertemuan (15 fase) dulu sebelum mengerjakan Posttest.');
        }

        return view('posttest', [
            'questions' => AssessmentQuestion::where('type', 'posttest')->orderBy('number')->get(),
            'timeLimit' => AssessmentSetting::timeLimitFor('posttest'),
        ]);
    }

    public function submitPretest(Request $request)
    {
        $questions = AssessmentQuestion::where('type', 'pretest')->orderBy('number')->get();
        $total     = $questions->count();
        $correct   = 0;

        foreach ($questions as $q) {
            if ($request->input("q{$q->number}") === $q->answer) {
                $correct++;
            }
        }

        $score = $total > 0 ? (int) round($correct / $total * 100) : 0;

        StudentScore::updateOrCreate(
            ['user_id' => Auth::id()],
            ['pretest' => $score]
        );

        return redirect()->route('lesson')->with('pretest_score', $score);
    }

    public function submitPosttest(Request $request)
    {
        $questions = AssessmentQuestion::where('type', 'posttest')->orderBy('number')->get();
        $total     = $questions->count();
        $correct   = 0;

        foreach ($questions as $q) {
            if ($request->input("q{$q->number}") === $q->answer) {
                $correct++;
            }
        }

        $score = $total > 0 ? (int) round($correct / $total * 100) : 0;

        StudentScore::updateOrCreate(
            ['user_id' => Auth::id()],
            ['posttest' => $score]
        );

        return redirect()->route('grade')->with('posttest_score', $score);
    }
}
