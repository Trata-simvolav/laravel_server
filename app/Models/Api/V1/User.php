<?php

namespace App\Models\Api\V1;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fio',
        'birthday',
        'gender_id',
        'email',
        'password',
        'action'
    ];

    // public function reviews()
    // {
    //     return $this->hasMany(Review::class);
    // }

    // public function ratings()
    // {
    //     return $this->hasMany(Rating::class);
    // }

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function isBanned()
    {
        return $this->banned;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
