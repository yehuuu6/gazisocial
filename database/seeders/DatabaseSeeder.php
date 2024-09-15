<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Role;
use App\Models\Tag;
use App\Models\Activity;
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

        $users = User::factory(10)->create()->each(function ($user) {
            Activity::create([
                'user_id' => $user->id,
                'content' => "Gazi Social'a katıldı!",
            ]);
        });

        $tags = Tag::factory(30)->create();

        $posts = Post::factory(50)
            ->withFixture()
            ->has(Comment::factory(33)->recycle($users))
            ->recycle($users)
            ->create()
            ->each(function ($post) use ($tags) {
                // Randomly assign between 1 and 5 tags to each post
                $post->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')->toArray()
                );

                // Create activity for each post
                Activity::create([
                    'user_id' => $post->user_id,
                    'post_id' => $post->id,
                    'content' => 'Yeni bir konu oluşturdu!',
                    'link' => $post->showRoute(),
                ]);
            });

        // Create a user with custom attributes
        $user1 = User::create([
            'name' => 'Eren Aydın',
            'username' => 'yehuuu6',
            'avatar' => 'https://ui-avatars.com/api/?name=Eren%20Aydın&background=random',
            'email' => 'eren.aydin@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        Activity::create([
            'user_id' => $user1->id,
            'content' => "Gazi Social'a katıldı!",
        ]);

        // Add gazi social role to the user
        $user1->roles()->attach($owner);
        $user1->roles()->attach($gazili);

        $user2 = User::create([
            'name' => 'Ahmet Kandaz',
            'username' => 'KaNEX',
            'avatar' => 'https://ui-avatars.com/api/?name=Ahmet%20Kandaz&background=random',
            'email' => 'kanex@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        Activity::create([
            'user_id' => $user2->id,
            'content' => "Gazi Social'a katıldı!",
        ]);

        $user3 = User::create([
            'name' => 'Melek Güleç',
            'username' => 'melekisnothere',
            'avatar' => 'https://ui-avatars.com/api/?name=Melek%20Güleç&background=random',
            'email' => 'melek.gulec@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        Activity::create([
            'user_id' => $user3->id,
            'content' => "Gazi Social'a katıldı!",
        ]);

        $user3->roles()->attach($admin);
        $user3->roles()->attach($gazili);
    }
}
