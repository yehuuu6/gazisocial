<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\SendEmailVerification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\Auth\QueuedResetPassword;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword, FilamentUser, HasAvatar
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
        'gender',
        'password',
        'last_activity',
    ];

    protected $attributes = [
        'bio' => 'Herhangi bir bilgi verilmedi.',
        'gender' => 'Belirtilmedi',
    ];

    protected static function booted()
    {

        // Set user's default avatar
        static::created(function ($user) {
            // Assign the 'uye' role to the user
            $user->assignRole(['uye']);
        });
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getAvatar();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->canDoHighLevelAction();
    }

    public function getAvatar(): string
    {
        if ($this->avatar) {
            return '/storage' . $this->avatar;
        } else {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
        }
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

    public function isNewAccount(): bool
    {
        // Check if the user account was created within 3 days
        return $this->created_at->diffInDays(now()) <= 3;
    }

    public function canPublishAPost(): bool
    {
        if ($this->isStudent()) {
            return true;
        }

        if ($this->canDoHighLevelAction()) {
            return true;
        }

        if ($this->isNewAccount()) {
            return false;
        }

        return true;
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function isStudent(): bool
    {
        // Return true if the user has the role with the slug 'gazili'
        return $this->hasRole('gazili');
    }

    /**
     * Return the strongest role user have
     */
    public function strongRole()
    {
        return $this->roles()->orderBy('level', 'desc')->first();
    }

    /**
     * Regular users, nothing going on here.
     */
    public function canDoLowLevelAction(): bool
    {
        // Return true if the users most powerful role is level 0
        return $this->roles()->max('level') === 0;
    }

    /**
     * High level users, can edit other users posts, delete comments etc something like Moderator.
     */
    public function canDoHighLevelAction(): bool
    {
        // Return true if the users most powerful role has a level of 1 or more
        return $this->roles()->max('level') >= 1;
    }

    /**
     * Critical level users, can delete other users posts, comments etc something like Admin.
     * Can create new roles, assign roles to other users etc. (Can only create roles with level 0 or 1)
     * Can't delete or update roles with level 2 or 3.
     */
    public function canDoCriticalAction(): bool
    {
        // Return true if the users most powerful role has a level of 2 or more
        return $this->roles()->max('level') >= 2;
    }

    /**
     * God level users, can do anything, no restrictions.
     * Ment for only Gazi Social role. DO NOT CREATE ANYTHING ELSE WITH LEVEL 3.
     */
    public function canBeAGod(): bool
    {
        // Return true if the users most powerful role is level 3
        return $this->roles()->max('level') === 3;
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function nonAnonymousPosts()
    {
        return $this->hasMany(Post::class)->where('is_anonim', false);
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
