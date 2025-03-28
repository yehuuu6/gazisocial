<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use App\Models\Poll;
use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Konular', Post::withoutGlobalScopes()->count())
                ->icon('heroicon-o-document-text')
                ->description('Toplam açılan konular')
                ->color('sky')
                ->chart(
                    $this->getPostsData()
                ),
            Stat::make('Yorumlar', Comment::count())
                ->icon('heroicon-o-chat-bubble-left-right')
                ->description('Toplam yapılan yorumlar')
                ->color('purple')
                ->chart(
                    $this->getCommentsData()
                ),
            Stat::make('Anketler', Poll::where('is_draft', false)->count())
                ->icon('heroicon-o-light-bulb')
                ->description('Toplam aktif anketler')
                ->color('teal')
                ->chart(
                    $this->getPollsData()
                ),
        ];
    }

    protected function getPostsData(): array
    {
        $data = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Post::withoutGlobalScopes()->whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return $data;
    }

    protected function getCommentsData(): array
    {
        $data = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Comment::whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return $data;
    }

    protected function getPollsData(): array
    {
        $data = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = Poll::where('is_draft', false)->whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return $data;
    }
}
