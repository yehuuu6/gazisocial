<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $users = User::factory(10)->create();

        // Create a user with custom attributes
        $user1 = User::create([
            'name' => 'Eren Aydın',
            'username' => 'yehuuu6',
            'gender' => 'erkek',
            'email' => 'eren.aydin@gazi.edu.tr',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user1->assignRole([
            'gazi-social',
            'ogrenci'
        ]);

        $user2 = User::create([
            'name' => 'Ahmet Kandaz',
            'username' => 'KaNEX',
            'gender' => 'Erkek',
            'email' => 'kanex@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user2->assignRole([
            'yonetici'
        ]);

        $user3 = User::create([
            'name' => 'Melek Güleç',
            'username' => 'melekisnothere',
            'email' => 'melek.gulec@gazi.edu.tr',
            'gender' => 'kadın',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user3->assignRole([
            'moderator',
            'ogrenci',
        ]);

        $user4 = User::create([
            'name' => 'Kaan Efe Karadaş',
            'username' => 'PsGl',
            'email' => 'kaan@gazi.edu.tr',
            'gender' => 'erkek',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user4->assignRole([
            'ogrenci',
        ]);

        $users[] = $user2;
        $users[] = $user3;
        $users[] = $user1;
        $users[] = $user4;

        $tags = Tag::all();

        $posts = Post::factory(50)
            ->withFixture()
            ->recycle($users)
            ->create()
            ->each(function ($post) use ($tags, $users) {
                foreach ($users as $user) {
                    if (rand(0, 1)) {
                        $like = Like::create([
                            'user_id' => $user->id,
                            'post_id' => $post->id,
                            'likeable_id' => $post->id,
                            'likeable_type' => 'post'
                        ]);

                        $like->addLike();
                    }
                }

                // Randomly assign between 1 and 4 tags to each post in a single operation
                $post->tags()->attach(
                    $tags->random(rand(1, 4))->pluck('id')->toArray()
                );
            });

        foreach ($posts as $post) {
            $comments = Comment::factory(rand(0, 5))
                ->recycle($users)
                ->create([
                    'post_id' => $post->id,
                    'parent_id' => null,
                    'commentable_id' => $post->id,
                    'commentable_type' => $post->getMorphClass(),
                ])->each(function ($comment) use ($users) {
                    foreach ($users as $user) {
                        if (rand(0, 1)) {
                            $like = Like::create([
                                'user_id' => $user->id,
                                'comment_id' => $comment->id,
                                'likeable_id' => $comment->id,
                                'likeable_type' => 'comment'
                            ]);

                            $like->addLike();
                        }
                    }
                });

            foreach ($comments as $comment) {
                $this->createReplies($comment, 0, $users);
            }
        }

        // Make the first 5 posts pinned
        $posts->take(5)->each(function ($post) {
            $post->update(['is_pinned' => true]);
        });
    }

    private function createReplies(Comment $comment, int $depth = 0, $users): void
    {

        if (rand(0, 1)) {
            return;
        }

        if ($depth > 3) {
            return;
        }

        $parentId = $comment->parent_id ?? $comment->id;

        $replies = Comment::factory(rand(0, 5))
            ->recycle($users)
            ->create([
                'post_id' => $comment->post_id,
                'parent_id' => $parentId,
                'commentable_id' => $comment->id,
                'commentable_type' => $comment->getMorphClass(),
            ])->each(function ($reply) use ($users) {
                foreach ($users as $user) {
                    if (rand(0, 1)) {
                        $like = Like::create([
                            'user_id' => $user->id,
                            'comment_id' => $reply->id,
                            'likeable_id' => $reply->id,
                            'likeable_type' => 'comment'
                        ]);

                        $like->addLike();
                    }
                }
            });

        foreach ($replies as $reply) {
            $this->createReplies($reply, $depth + 1, $users);
        }
    }
}
