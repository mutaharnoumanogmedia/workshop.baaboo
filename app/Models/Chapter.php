<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->where('video_type', 'video');
    }
    public function audios()
    {
        return $this->hasMany(Video::class)->where('video_type', 'audio');
    }

    public function resources()
    {
        return $this->hasMany(ChapterResource::class);
    }
}
