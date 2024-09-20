<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

use function Laravel\Prompts\progress;

class LikeLoadTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = Post::find(1);

        $progress = progress(label: 'Creating like', steps: 1000);

        $progress->start();
        LazyCollection::times(10)->each(function () use ($post, $progress) {
            Like::factory(100)->for($post, 'likeable')->create();

            $progress->advance(100);
        });

        $progress->finish();

        $post->increment('likes_count', 1000);
    }
}
