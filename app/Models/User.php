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
        'name',
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
    public function programs()
    {
        return $this->hasMany(Program::class);
    }


    public function scopenonadmin($query)
    {
        return $query->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'admin');
        });
    }



    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        foreach ($names as $n) {
            if (strlen($n) > 0) {
                $initials .= strtoupper($n[0]);
            }
        }
        return $initials;
    }
}
