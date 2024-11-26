<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\{
    HasMany,
    BelongsToMany
};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
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
        'password' => 'hashed',
    ];

    public function createdNotes(): HasMany
    {
        return $this->hasMany(Note::class, 'creator_id');
    }
    public function guestNotes(): BelongsToMany
    {
        return $this->belongsToMany(Note::class, 'user_notes');
    }
    public function friends()
    {
        return $this->belongsToMany(self::class, 'friends', 'user_id', 'friend_id')->withPivot('status');
    }
    public function friendRequests()
    {
        return $this->belongsToMany(self::class, 'friends', 'friend_id', 'user_id')->where('status', 0);
    }
}
