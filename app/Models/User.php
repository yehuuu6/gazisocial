<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\CanResetPassword;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'avatar',
        'bio',
        'email',
        'password',
        'is_private',
        'badge_visibility',
        'last_activity',
    ];

    protected static function booted()
    {

        // Set user's default avatar
        static::created(function ($user) {
            $user->avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random';
            $user->save();
        });

        static::created(function ($user) {
            Activity::create([
                'user_id' => $user->id,
                'content' => "Gazi Social'a katıldı!",
            ]);
        });
    }

    public function getCommentsCount()
    {
        return $this->comments_count + $this->replies_count;
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->orderBy('level', 'desc');
    }

    public function updateDefaultAvatar()
    {
        // check if the user has a default avatar by checking if the avatar contains ui-avatars.com
        if (strpos($this->avatar, 'ui-avatars.com') === false) return;

        $newAvatar = 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
        $this->avatar = $newAvatar;
        $this->save();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isStudent()
    {
        // Return true if the user has the role with the id 1
        return $this->roles->contains('id', 1);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_activity' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
