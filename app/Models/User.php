<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\SendEmailVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Auth\QueuedResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'last_activity',
    ];

    protected static function booted()
    {

        // Set user's default avatar
        static::created(function ($user) {
            $user->avatar = 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random';
            $user->save();

            // Assign the 'member' role to the user
            $user->assignRole(['member']);
        });
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Update the user's last activity.
     */
    public function heartbeat()
    {
        $this->last_activity = now();
        $this->save();
    }

    public function hasRole(string $role_slug)
    {
        return $this->roles->contains('slug', $role_slug);
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new SendEmailVerification);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new QueuedResetPassword($token));
    }

    public function getCommentsCount(): int
    {
        return $this->comments_count + $this->replies_count;
    }

    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    public function assignRole(array $slugs)
    {
        foreach ($slugs as $slug) {
            $role = Role::where('slug', $slug)->first();
            if ($role) $this->roles()->attach($role);
        }
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles')->orderBy('level', 'desc');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function isStudent(): bool
    {
        // Return true if the user has the role with the slug 'student'
        return $this->hasRole('student');
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
