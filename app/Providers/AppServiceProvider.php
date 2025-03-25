<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Reply;
use App\Models\Comment;
use App\Observers\PostObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\GiphyController;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(GiphyController::class, function ($app) {
            return new GiphyController();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('tr');

        Model::preventLazyLoading(! app()->isProduction());

        Relation::morphMap([
            'post' => Post::class,
            'comment' => Comment::class,
            'reply' => Reply::class,
            'posts' => Post::class,
            'comments' => Comment::class,
        ]);

        // Register observers
        Post::observe(PostObserver::class);
    }
}
