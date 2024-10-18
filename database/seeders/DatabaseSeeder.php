<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Reply;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
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

        // Create a user with custom attributes
        $user1 = User::create([
            'name' => 'Eren Aydın',
            'username' => 'yehuuu6',
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
            'email' => 'kanex@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user3 = User::create([
            'name' => 'Melek Güleç',
            'username' => 'melekisnothere',
            'email' => 'melek.gulec@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user3->roles()->attach($admin);
        $user3->roles()->attach($gazili);

        $users[] = $user2;
        $users[] = $user3;
        $users[] = $user1;

        $tags = collect();

        $tags->push(Tag::create(['name' => 'Staj', 'color' => 'blue']));
        $tags->push(Tag::create(['name' => 'Soru', 'color' => 'green']));
        $tags->push(Tag::create(['name' => 'İtiraf', 'color' => 'red']));
        $tags->push(Tag::create(['name' => 'Etkinlik', 'color' => 'yellow']));
        $tags->push(Tag::create(['name' => 'Erasmus', 'color' => 'purple']));
        $tags->push(Tag::create(['name' => 'Burslar', 'color' => 'orange']));
        $tags->push(Tag::create(['name' => 'Projeler', 'color' => 'pink']));
        $tags->push(Tag::create(['name' => 'Ulaşım', 'color' => 'cyan']));
        $tags->push(Tag::create(['name' => 'Seyahat', 'color' => 'teal']));
        $tags->push(Tag::create(['name' => 'Yemek', 'color' => 'indigo']));
        $tags->push(Tag::create(['name' => 'Arkadaşlık', 'color' => 'lime']));
        $tags->push(Tag::create(['name' => 'Spor', 'color' => 'emerald']));
        $tags->push(Tag::create(['name' => 'Yurtlar', 'color' => 'amber']));

        Post::factory(rand(30, 100))
            ->withFixture()
            ->recycle($users)
            ->create()
            ->each(function ($post) use ($tags, $users) {

                foreach ($users as $user) {
                    if (rand(0, 1)) {
                        Like::create([
                            'user_id' => $user->id,
                            'likeable_id' => $post->id,
                            'likeable_type' => 'post'
                        ]);
                    }
                }

                // Randomly assign between 1 and 4 tags to each post in a single operation
                $post->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')->toArray()
                );
                // Create comments between 0 and 30 for each post
                Comment::factory(rand(0, 30))
                    ->recycle($users)
                    ->create(['post_id' => $post->id])
                    ->each(function ($comment) use ($users) {

                        foreach ($users as $user) {
                            if (rand(0, 1)) {
                                Like::create([
                                    'user_id' => $user->id,
                                    'likeable_id' => $comment->id,
                                    'likeable_type' => 'comment'
                                ]);
                            }
                        }

                        // Create replies between 0 and 10 for each comment
                        Reply::factory(rand(0, 10))
                            ->recycle($users)
                            ->create(['comment_id' => $comment->id])
                            ->each(function ($reply) use ($users) {

                                foreach ($users as $user) {
                                    if (rand(0, 1)) {
                                        Like::create([
                                            'user_id' => $user->id,
                                            'likeable_id' => $reply->id,
                                            'likeable_type' => 'reply'
                                        ]);
                                    }
                                }
                            });
                    });
            });
    }
}
