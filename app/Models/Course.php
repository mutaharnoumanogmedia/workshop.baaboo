<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeMyCourses($query, $userId = null)
    {
        $userId = $userId ?: auth()->id();

        return $query->whereIn('id', function ($subQuery) use ($userId) {
            $subQuery->select('course_id')
                ->from('user_courses')
                ->where('user_id', $userId);
        });
    }
}
