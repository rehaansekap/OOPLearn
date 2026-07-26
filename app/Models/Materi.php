<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = ['title', 'content', 'video_path', 'video_url', 'color', 'sort_order'];

    /**
     * Ubah berbagai format URL YouTube (watch, youtu.be, embed) jadi URL embed.
     */
    public function embedUrl(): ?string
    {
        if (!$this->video_url) {
            return null;
        }

        preg_match(
            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/',
            $this->video_url,
            $matches
        );

        $videoId = $matches[1] ?? null;

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}
