<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Carbon::setLocale('tr');

        Model::preventLazyLoading();

        Relation::morphMap([
            'posts' => Post::class,
            'comments' => Comment::class,
        ]);
    }
}
