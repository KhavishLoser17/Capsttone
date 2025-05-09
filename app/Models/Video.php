<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    use HasFactory;
    protected $table = 'videos';

    protected $fillable = [
        'video_type',
        'youtube_url',
        'video_path'
    ];

    // Validate YouTube URL
    public static function extractYouTubeVideoId($url)
    {
        $patterns = [
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            '/^([a-zA-Z0-9_-]{11})$/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    // Normalize YouTube URL
    public static function normalizeYouTubeUrl($url)
    {
        $videoId = self::extractYouTubeVideoId($url);
        return $videoId ? "https://www.youtube.com/watch?v={$videoId}" : null;
    }

    // Accessor for embed URL
    public function getEmbedUrlAttribute()
    {
        $videoId = self::extractYouTubeVideoId($this->youtube_url);
        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }
}
