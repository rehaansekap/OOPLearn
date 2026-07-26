<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    public function showLesson()
    {
        return view('lesson', [
            'materis' => Materi::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'     => 'required|string|max:200',
            'content'   => 'nullable|string',
            'color'     => 'required|in:green,blue,purple,indigo,amber',
            'video'     => 'nullable|file|mimes:mp4,webm,ogg,mov|max:204800',
            'video_url' => 'nullable|url|max:500',
        ]);

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos/materi', 'public');
        }

        Materi::create([
            'title'      => $data['title'],
            'content'    => $data['content'] ?? null,
            'video_path' => $videoPath,
            'video_url'  => $data['video_url'] ?? null,
            'color'      => $data['color'],
            'sort_order' => (Materi::max('sort_order') ?? 0) + 1,
        ]);

        return redirect()->route('dashboard.guru', ['section' => 'materi'])
            ->with('materi_success', 'Materi berhasil ditambahkan.');
    }

    public function update(Request $request, Materi $materi)
    {
        $data = $request->validate([
            'title'        => 'required|string|max:200',
            'content'      => 'nullable|string',
            'color'        => 'required|in:green,blue,purple,indigo,amber',
            'video'        => 'nullable|file|mimes:mp4,webm,ogg,mov|max:204800',
            'video_url'    => 'nullable|url|max:500',
            'remove_video' => 'nullable|boolean',
        ]);

        $videoPath = $materi->video_path;

        if ($request->boolean('remove_video')) {
            if ($videoPath) Storage::disk('public')->delete($videoPath);
            $videoPath = null;
        } elseif ($request->hasFile('video')) {
            if ($videoPath) Storage::disk('public')->delete($videoPath);
            $videoPath = $request->file('video')->store('videos/materi', 'public');
        }

        $materi->update([
            'title'      => $data['title'],
            'content'    => $data['content'] ?? null,
            'video_path' => $videoPath,
            'video_url'  => $data['video_url'] ?? null,
            'color'      => $data['color'],
        ]);

        return redirect()->route('dashboard.guru', ['section' => 'materi'])
            ->with('materi_success', 'Materi berhasil diperbarui.');
    }

    public function destroy(Materi $materi)
    {
        if ($materi->video_path) {
            Storage::disk('public')->delete($materi->video_path);
        }
        $materi->delete();

        return redirect()->route('dashboard.guru', ['section' => 'materi'])
            ->with('materi_success', 'Materi berhasil dihapus.');
    }
}
