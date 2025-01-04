<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Like;
use App\Models\Poll;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Comment;
use App\Models\PollVote;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\PollOption;
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
                            'likeable_id' => $post->id,
                            'likeable_type' => 'post'
                        ]);

                        $like->addLike();
                    }
                }

                // Create poll with a chance of 25% using PollFactory, PollOptionFactory and PollVoteFactory
                if (rand(0, 3) === 0) {
                    $poll = Poll::factory()->create([
                        'user_id' => $post->user_id,
                        'post_id' => $post->id
                    ]);
                    $options = PollOption::factory(rand(2, 5))->create(['poll_id' => $poll->id]);
                    // Create votes using users
                    foreach ($users as $user) {
                        if (rand(0, 1)) {
                            PollVote::create([
                                'poll_id' => $poll->id,
                                'user_id' => $user->id,
                                'poll_option_id' => $options->random()->id
                            ]);
                        }
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
                    'commentable_id' => $post->id,
                    'commentable_type' => $post->getMorphClass(),
                    'depth' => 0,
                ]);

            foreach ($comments as $comment) {
                $this->createReplies($comment);
            }
        }

        $this->call([
            FacultySeeder::class,
            ContactMessagesSeeder::class,
        ]);
    }

    public function createReplies(Comment $comment, int $depth = 0): void
    {

        if (rand(0, 1)) {
            return;
        }

        if ($depth > 3) {
            return;
        }

        $replies = Comment::factory(rand(0, 5))
            ->recycle(User::all())
            ->create([
                'post_id' => $comment->post_id,
                'commentable_id' => $comment->id,
                'commentable_type' => $comment->getMorphClass(),
                'depth' => $depth + 1,
            ]);

        foreach ($replies as $reply) {
            $this->createReplies($reply, $depth + 1);
        }
    }
}
