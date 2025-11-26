<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterResource extends Model
{
    use HasFactory;
    protected $fillable = [
        'chapter_id',
        'title',
        'resource_type', // e.g., 'pdf', 'link'
        'url',
    ];
    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
