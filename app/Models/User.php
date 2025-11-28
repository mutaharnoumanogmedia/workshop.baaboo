<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
    public function videoViews()
    {
        return $this->hasMany(VideoViewer::class);
    }
    public function comments()
    {
        return $this->hasMany(VideoComment::class);
    }
    public function reactions()
    {
        return $this->hasMany(VideoReaction::class);
    }
    public function favorites()
    {
        return $this->hasMany(UserFavoriteVideo::class);
    }
    public function myCourses()
    {
        return $this->hasMany(UserCourse::class);
    }
    public function myPrograms()
    {
        return $this->hasMany(UserProgram::class);
    }
    public function programs()
    {
        return $this->hasMany(UserProgram::class);
    }
    public function courses()
    {
        return $this->hasMany(UserCourse::class);
    }


    public function scopenonadmin($query)
    {
        return $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        });
    }



    public function getInitialsAttribute()
    {
        $initials = strtoupper(substr($this->first_name, 0, 1));
        if (!empty($this->last_name)) {
            $initials .= strtoupper(substr($this->last_name, 0, 1));
        }
        return $initials;
    }

    public function getFullNameAttribute()
    {
        $fullName = $this->first_name  . " " . ($this->last_name ?? "");
        return trim($fullName);
    }
}
