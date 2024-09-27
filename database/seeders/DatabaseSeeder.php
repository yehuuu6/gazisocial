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

        $posts = Post::factory(50)
            ->withFixture()
            ->has(Comment::factory(30)->recycle($users))
            ->recycle($users)
            ->create()
            ->each(function ($post) use ($tags, $users) {
                // Randomly assign between 1 and 4 tags to each post in a single operation
                $post->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')->toArray()
                );

                // Preload post comments count
                $post->update(['comments_count' => $post->comments->count()]);

                // Add 1 to 5 replies to each comment
                $post->comments->each(function ($comment) use ($users) {
                    $replyCount = rand(0, 5);
                    if ($replyCount === 0) {
                        return;
                    }

                    // Create replies, assigning a random user to each one
                    Reply::factory($replyCount)->create([
                        'comment_id' => $comment->id,
                    ])->each(function ($reply) use ($users) {
                        // Assign a random user to each reply
                        $reply->update([
                            'user_id' => $users->random()->id,
                        ]);
                    });

                    // Update replies_count for the comment in one go
                    $comment->increment('replies_count', $replyCount);
                });
            });


        $comments = Comment::all();

        // Create Likes for each user
        foreach ($users as $user) {
            // Generate a random number of likes for posts between 0 and the number of available posts
            $postLikesCount = rand(0, $posts->count());
            $posts->random($postLikesCount)->each(function ($post) use ($user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $post->id,
                    'likeable_type' => $post->getMorphClass(),
                ]);

                $post->increment('likes_count');
            });

            // Generate a random number of likes for comments between 0 and the number of available comments
            $commentLikesCount = rand(0, $comments->count());
            $comments->random($commentLikesCount)->each(function ($comment) use ($user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $comment->id,
                    'likeable_type' => $comment->getMorphClass(),
                ]);

                $comment->increment('likes_count');
            });
        }
    }
}
