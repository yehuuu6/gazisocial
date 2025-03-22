<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'slug',
        'name',
        'color',
        'level',
    ];

    // Set slug on model creation
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            $role->slug = Str::slug($role->name);
        });

        static::updating(function ($role) {
            if ($role->isDirty('name')) {
                $role->slug = Str::slug($role->name);
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
