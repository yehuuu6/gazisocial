<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Role;
use App\Models\Tag;
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

        $tags = Tag::factory(10)->create();  // Creates 10 random tags

        $posts = Post::factory(50)
            ->has(Comment::factory(33)->recycle($users))
            ->recycle($users)
            ->create()
            ->each(function ($post) use ($tags) {
                // Randomly assign between 1 and 5 tags to each post
                $post->tags()->attach(
                    $tags->random(rand(1, 5))->pluck('id')->toArray()
                );
            });

        // Create a user with custom attributes
        $user1 = User::create([
            'name' => 'Eren Aydın',
            'username' => 'yehuuu6',
            'avatar' => 'https://ui-avatars.com/api/?name=eren aydin&background=random',
            'email' => 'eren.aydin@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        // Add gazi social role to the user
        $user1->roles()->attach($owner);
        $user1->roles()->attach($gazili);

        $user2 = User::create([
            'name' => 'Ahmet Kandaz',
            'username' => 'KaNEX',
            'avatar' => 'https://ui-avatars.com/api/?name=ahmet kandaz&background=random',
            'email' => 'kanex@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user3 = User::create([
            'name' => 'Melek Güleç',
            'username' => 'melekisnothere',
            'avatar' => 'https://ui-avatars.com/api/?name=melek gulec&background=random',
            'email' => 'melek.gulec@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user3->roles()->attach($admin);
        $user3->roles()->attach($gazili);
    }
}
