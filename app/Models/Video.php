<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'video_type', // e.g., 'video', 'audio'
        'chapter_id',
        'vturb_key',
        'duration',
        'status'
    ];

    public function favoriteByUsers()
    {
        return $this->belongsToMany(UserFavoriteVideo::class);
    }

    public function usersWhoFavorited()
    {
        return $this->belongsToMany(User::class, 'user_favorite_videos', 'video_id', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function userFavorites()
    {
        return $this->hasMany(UserFavoriteVideo::class);
    }

    public function comments()
    {
        return $this->hasMany(VideoComment::class);
    }

    public function reactions()
    {
        return $this->hasMany(VideoReaction::class);
    }

    public function viewers()
    {
        return $this->belongsToMany(VideoViewer::class);
    }
}
