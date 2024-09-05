<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $gazili = Role::create(['name' => 'öğrenci', 'color' => 'green', 'level' => 0]);
        $admin = Role::create(['name' => 'yönetici', 'color' => 'red', 'level' => 1]);
        $owner = Role::create(['name' => 'gazi social', 'color' => 'blue', 'level' => 2]);

        $users = User::factory(10)->create();

        $posts = Post::factory(50)
        ->has(Comment::factory(33)->recycle($users))
        ->recycle($users)
        ->create();

        // Create a user with custom attributes
        $user = User::create([
            'name' => 'Eren Aydın',
            'username' => 'yehuuu6',
            'avatar' => 'https://ui-avatars.com/api/?name=eren aydin&background=random',
            'email' => 'eren.aydin@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        // Add gazi social role to the user
        $user->roles()->attach($owner);
        $user->roles()->attach($gazili);
    }
}
