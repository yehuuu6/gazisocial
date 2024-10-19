<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Vite;
use App\Models\Like;
use App\Observers\PostObserver;
use App\Observers\CommentObserver;
use App\Observers\ReplyObserver;
use App\Observers\LikeObserver;

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
        // Start observing the models
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);
        Reply::observe(ReplyObserver::class);
        Like::observe(LikeObserver::class);

        Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
            $full_trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, limit: 6);
            $trace = array_pop($full_trace);

            $file_parts = explode('/', $trace['file']);
            $file  = array_pop($file_parts);

            $class = get_class($model);

            // Throw an exception if the relation is not loaded
            throw new \Exception("Attempted to lazy load [{$relation}] on [line:{$trace['line']}] in [{$file}] for model [{$class}].");
        });

        Vite::prefetch(concurrency: 3);

        Carbon::setLocale('tr');

        Model::preventLazyLoading();

        Relation::morphMap([
            'post' => Post::class,
            'comment' => Comment::class,
            'reply' => Reply::class,
        ]);
    }
}
