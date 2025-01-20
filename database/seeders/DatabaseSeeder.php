<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ReportedBug;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $pistoltim = Role::create(['slug' => 'pistoltim', 'name' => 'Pistol Tim', 'color' => 'yellow', 'level' => 0]);
        $gazili = Role::create(['slug' => 'student', 'name' => 'Öğrenci', 'color' => 'green', 'level' => 0]);
        $admin = Role::create(['slug' => 'admin', 'name' => 'Yönetici', 'color' => 'red', 'level' => 1]);
        $owner = Role::create(['slug' => 'gazisocial', 'name' => 'Gazi Social', 'color' => 'blue', 'level' => 2]);

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
        $user1->roles()->attach($pistoltim);
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

        // Create bug reports using users
        $users->each(function ($user) {
            ReportedBug::factory(rand(0, 5))->create(['user_id' => $user->id]);
        });

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

        $posts = Post::factory(30)
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
            $comments = Comment::factory(rand(0, 20))
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

        // Run additional seeders
        $this->call([
            FacultySeeder::class,
            ContactMessagesSeeder::class,
        ]);
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
