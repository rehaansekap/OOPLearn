<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Fase5Controller;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\BlueprintController;
use App\Http\Controllers\SimulasiController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MateriController;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSetting;
use App\Models\Materi;

/*
|--------------------------------------------------------------------------
| Welcome
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Redirect setelah login
|--------------------------------------------------------------------------
*/

Route::get('/home', function () {
    $user = Auth::user();

    if ($user->role === 'guru') {
        return redirect()->route('dashboard.guru');
    }

    return redirect()->route('dashboard.siswa');
})->middleware('auth')->name('home');

/*
|--------------------------------------------------------------------------
| Force Logout (Debug)
|--------------------------------------------------------------------------
*/

Route::get('/force-logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

/*
|--------------------------------------------------------------------------
| Dashboard Guru
|--------------------------------------------------------------------------
*/

Route::get('/dashboard-guru', function () {
    $siswas = User::query()->where('role', 'siswa')
                ->with(['learningProgress', 'score'])
                ->get();

    return view('dashboardGuru', [
        'siswas'            => $siswas,
        'totalSiswa'        => $siswas->count(),
        'totalRefleksi'     => 0,
        'pretestQuestions'  => AssessmentQuestion::where('type', 'pretest')->orderBy('number')->get(),
        'posttestQuestions' => AssessmentQuestion::where('type', 'posttest')->orderBy('number')->get(),
        'pretestTime'       => AssessmentSetting::timeLimitFor('pretest'),
        'posttestTime'      => AssessmentSetting::timeLimitFor('posttest'),
        'materis'           => Materi::orderBy('sort_order')->get(),
    ]);
})->middleware('auth')->name('dashboard.guru');

Route::get('/guru/data-nilai/export', [GuruController::class, 'exportNilai'])
    ->middleware('auth')
    ->name('guru.export.nilai');

Route::prefix('guru/materi')->middleware('auth')->name('guru.materi.')->group(function () {
    Route::post('/',                  [MateriController::class, 'store'])->name('store');
    Route::post('/{materi}/update',   [MateriController::class, 'update'])->name('update');
    Route::post('/{materi}/delete',   [MateriController::class, 'destroy'])->name('destroy');
});

Route::prefix('guru/assessment')->middleware('auth')->name('guru.assessment.')->group(function () {
    Route::post('/questions',                [GuruController::class, 'storeQuestion'])->name('store');
    Route::put('/questions/{question}',      [GuruController::class, 'updateQuestion'])->name('update');
    Route::delete('/questions/{question}',   [GuruController::class, 'destroyQuestion'])->name('destroy');
    Route::post('/settings',                 [GuruController::class, 'updateSettings'])->name('settings');
});

/*
|--------------------------------------------------------------------------
| Halaman Siswa
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard-siswa', function () {
        $progress = \App\Models\LearningProgress::where('user_id', Auth::id())->first();

        // Helper: hitung fase selesai secara sequential per pertemuan (berhenti di gap pertama)
        $seqCount = function (array $keys) use ($progress): int {
            $n = 0;
            foreach ($keys as $k) { if ($progress?->$k) $n++; else break; }
            return $n;
        };

        $p1Done = $seqCount(['fase1','fase2','fase3','fase4','fase5']);
        $p2Done = $seqCount(['p2_fase1','p2_fase2','p2_fase3','p2_fase4','p2_fase5']);
        $p3Done = $seqCount(['p3_fase1','p3_fase2','p3_fase3','p3_fase4','p3_fase5']);

        // Logika buka pertemuan: P2 buka setelah P1 fase 5 selesai; P3 buka setelah P2 fase 5 selesai
        $p2Unlocked = $p1Done >= 5;
        $p3Unlocked = $p2Done >= 5;

        // Global progress dari 15 fase total
        $totalDone  = $p1Done + ($p2Unlocked ? $p2Done : 0) + ($p3Unlocked ? $p3Done : 0);
        $progressPct = (int)round($totalDone / 15 * 100);

        return view('dashboardSiswa', [
            'p1Done'      => $p1Done,
            'p2Done'      => $p2Done,
            'p3Done'      => $p3Done,
            'p2Unlocked'  => $p2Unlocked,
            'p3Unlocked'  => $p3Unlocked,
            'totalDone'   => $totalDone,
            'progressPct' => $progressPct,
        ]);
    })->name('dashboard.siswa');

    /*
    |--------------------------------------------------------------------------
    | Assessment
    |--------------------------------------------------------------------------
    */

    Route::view('/assessment', 'assessment')->name('assessment');
    Route::get('/pretest',  [AssessmentController::class, 'showPretest'])->name('pretest');
    Route::get('/posttest', [AssessmentController::class, 'showPosttest'])->name('posttest');

    Route::post('/submit-pretest',  [AssessmentController::class, 'submitPretest'])->name('submit.pretest');
    Route::post('/submit-posttest', [AssessmentController::class, 'submitPosttest'])->name('submit.posttest');

    /*
    |--------------------------------------------------------------------------
    | Lesson
    |--------------------------------------------------------------------------
    */

    Route::get('/lesson', [MateriController::class, 'showLesson'])->name('lesson');

    /*
    |--------------------------------------------------------------------------
    | Activity (Needham)
    |--------------------------------------------------------------------------
    */

    Route::view('/fase1', 'fase1')->name('fase1');
    Route::view('/fase2', 'fase2')->name('fase2');
    Route::view('/fase3', 'fase3')->name('fase3');
    Route::get('/fase4', [BlueprintController::class, 'enkapsulasi'])->name('fase4');
    Route::view('/fase4baru', 'fase4baru')->name('fase4baru');
    Route::get('/fase5', function () {
        $fase2 = \App\Models\Fase2Jawaban::where('user_id', Auth::id())
            ->where('pertemuan', 1)
            ->latest()
            ->first();

        return view('fase5', ['jawabanFase2' => $fase2?->jawaban]);
    })->name('fase5');

    /*
    |--------------------------------------------------------------------------
    | Pertemuan 2 – Inheritance
    |--------------------------------------------------------------------------
    */

    Route::prefix('pertemuan-2')->name('p2.')->group(function () {
        $faseNames = ['Orientasi', 'Pencetusan Ide', 'Penstrukturan Ide', 'Aplikasi', 'Refleksi'];

        foreach ([1, 2, 3, 5] as $f) {
            Route::get("/fase{$f}", function () use ($f, $faseNames) {
                return view('pertemuan-fase', [
                    'pertemuan' => 2,
                    'fase'      => $f,
                    'faseNama'  => $faseNames[$f - 1],
                    'topikNama' => 'Inheritance',
                    'warna'     => 'blue',
                    'warnaHex'  => '#2563eb',
                ]);
            })->name("fase{$f}");
        }
        Route::get('/fase4', [BlueprintController::class, 'inheritance'])->name('fase4');
    });

    /*
    |--------------------------------------------------------------------------
    | Pertemuan 3 – Polymorphism
    |--------------------------------------------------------------------------
    */

    Route::prefix('pertemuan-3')->name('p3.')->group(function () {
        $faseNames = ['Orientasi', 'Pencetusan Ide', 'Penstrukturan Ide', 'Aplikasi', 'Refleksi'];

        foreach ([1, 2, 3, 5] as $f) {
            Route::get("/fase{$f}", function () use ($f, $faseNames) {
                return view('pertemuan-fase', [
                    'pertemuan' => 3,
                    'fase'      => $f,
                    'faseNama'  => $faseNames[$f - 1],
                    'topikNama' => 'Enkapsulasi & Inheritance',
                    'warna'     => 'purple',
                    'warnaHex'  => '#9333ea',
                ]);
            })->name("fase{$f}");
        }
        Route::get('/fase4', [BlueprintController::class, 'gabungan'])->name('fase4');
    });

    /*
    |--------------------------------------------------------------------------
    | Progress Fase
    |--------------------------------------------------------------------------
    */

    Route::post('/fase1/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->fase1 = true;
        $p->save();
        return redirect()->route('fase2');
    })->name('fase1.complete');

    Route::post('/fase2/complete', function (Request $request) {
        \App\Models\Fase2Jawaban::create([
            'user_id'   => Auth::id(),
            'pertemuan' => 1,
            'jawaban'   => json_decode($request->input('jawaban'), true),
        ]);

        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->fase1 = true; $p->fase2 = true;
        $p->save();
        return redirect()->route('fase3');
    })->name('fase2.complete');

    Route::post('/fase3/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->fase1 = true; $p->fase2 = true; $p->fase3 = true;
        $p->save();
        return redirect()->route('fase4');
    })->name('fase3.complete');

    Route::post('/fase4/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->fase1 = true; $p->fase2 = true; $p->fase3 = true; $p->fase4 = true;
        $p->save();
        return redirect()->route('fase5');
    })->name('fase4.complete');

    Route::post('/fase5/store', [Fase5Controller::class, 'store'])->name('fase5.store');

    /*
    |--------------------------------------------------------------------------
    | Progress Fase – Pertemuan 2 (Inheritance)
    |--------------------------------------------------------------------------
    */

    Route::post('/pertemuan-2/fase1/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p2_fase1 = true;
        $p->save();
        return redirect()->route('p2.fase2');
    })->name('p2.fase1.complete');

    Route::post('/pertemuan-2/fase2/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p2_fase1 = true; $p->p2_fase2 = true;
        $p->save();
        return redirect()->route('p2.fase3');
    })->name('p2.fase2.complete');

    Route::post('/pertemuan-2/fase3/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p2_fase1 = true; $p->p2_fase2 = true; $p->p2_fase3 = true;
        $p->save();
        return redirect()->route('p2.fase4');
    })->name('p2.fase3.complete');

    Route::post('/pertemuan-2/fase4/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p2_fase1 = true; $p->p2_fase2 = true; $p->p2_fase3 = true; $p->p2_fase4 = true;
        $p->save();
        return redirect()->route('p2.fase5');
    })->name('p2.fase4.complete');

    Route::post('/pertemuan-2/fase5/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p2_fase1 = true; $p->p2_fase2 = true; $p->p2_fase3 = true;
        $p->p2_fase4 = true; $p->p2_fase5 = true;
        $p->save();
        return redirect()->route('dashboard.siswa');
    })->name('p2.fase5.complete');

    /*
    |--------------------------------------------------------------------------
    | Progress Fase – Pertemuan 3 (Proyek Akhir)
    |--------------------------------------------------------------------------
    */

    Route::post('/pertemuan-3/fase1/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p3_fase1 = true;
        $p->save();
        return redirect()->route('p3.fase2');
    })->name('p3.fase1.complete');

    Route::post('/pertemuan-3/fase2/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p3_fase1 = true; $p->p3_fase2 = true;
        $p->save();
        return redirect()->route('p3.fase3');
    })->name('p3.fase2.complete');

    Route::post('/pertemuan-3/fase3/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p3_fase1 = true; $p->p3_fase2 = true; $p->p3_fase3 = true;
        $p->save();
        return redirect()->route('p3.fase4');
    })->name('p3.fase3.complete');

    Route::post('/pertemuan-3/fase4/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p3_fase1 = true; $p->p3_fase2 = true; $p->p3_fase3 = true; $p->p3_fase4 = true;
        $p->save();
        return redirect()->route('p3.fase5');
    })->name('p3.fase4.complete');

    Route::post('/pertemuan-3/fase5/complete', function () {
        $p = \App\Models\LearningProgress::firstOrCreate(['user_id' => Auth::id()]);
        $p->p3_fase1 = true; $p->p3_fase2 = true; $p->p3_fase3 = true;
        $p->p3_fase4 = true; $p->p3_fase5 = true;
        $p->save();
        return redirect()->route('dashboard.siswa');
    })->name('p3.fase5.complete');

    Route::view('/grade', 'grade')->name('grade');

    Route::view('/informasi', 'informasi')->name('informasi');

    /*
    |--------------------------------------------------------------------------
    | Blueprint Builder (ICS)
    |--------------------------------------------------------------------------
    */

    Route::prefix('blueprint')->name('blueprint.')->group(function () {
        Route::get('/',             [BlueprintController::class, 'builder'])->name('builder');
        Route::get('/enkapsulasi',  [BlueprintController::class, 'enkapsulasi'])->name('enkapsulasi');
        Route::get('/inheritance',  [BlueprintController::class, 'inheritance'])->name('inheritance');
        Route::post('/simpan',      [BlueprintController::class, 'simpan'])->name('simpan');
        Route::get('/muat/{token}', [BlueprintController::class, 'muat'])->name('muat');
    });

    /*
    |--------------------------------------------------------------------------
    | Simulasi (ICS)
    |--------------------------------------------------------------------------
    */

    Route::prefix('simulasi')->name('simulasi.')->group(function () {
        Route::get('/',          [SimulasiController::class, 'index'])->name('index');
        Route::post('/jalankan', [SimulasiController::class, 'jalankan'])->name('jalankan');
        Route::post('/hasil',    [SimulasiController::class, 'simpanHasil'])->name('hasil');
        Route::get('/rekap',     [SimulasiController::class, 'rekap'])->name('rekap');

        // ---> TAMBAHAN: Rute baru untuk purwarupa interaktif Enkapsulasi <---
        Route::view('/enkapsulasi', 'simulasi.enkapsulasi')->name('enkapsulasi');
    });

    /*
    |--------------------------------------------------------------------------
    | Profil Peserta Didik
    |--------------------------------------------------------------------------
    */

    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');

    Route::post('/profil/update', function (Request $request) {
        $request->validateWithBag('profile', [
            'name'  => 'required|string|max:255',
            'kelas' => 'nullable|string|max:100',
        ]);

        auth()->user()->update([
            'name'  => $request->name,
            'kelas' => $request->kelas ?: null,
        ]);

        return back()->with('success', 'Data profil berhasil diperbarui.');
    })->name('profil.update');

    Route::post('/profil/password', function (Request $request) {
        $request->validateWithBag('password_change', [
            'current_password' => 'required',
            'password'         => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(
                ['current_password' => 'Kata sandi saat ini tidak sesuai.'],
                'password_change'
            );
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success_password', 'Kata sandi berhasil diperbarui.');
    })->name('profil.password');

    /*
    |--------------------------------------------------------------------------
    | Product Tour (Onboarding)
    |--------------------------------------------------------------------------
    */

    Route::post('/tour/complete', function () {
        auth()->user()->update(['has_seen_tour' => true]);
        return response()->noContent();
    })->name('tour.complete');

});

/*
|--------------------------------------------------------------------------
| Sandbox – Eksperimen UI (tidak butuh auth)
|--------------------------------------------------------------------------
*/
Route::view('/eksperimen-puzzle', 'sandbox.custom-puzzle');
