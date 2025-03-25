<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Yeni Kullanıcılar', User::where('created_at', '>=', now()->subDays(1))->count())
                ->icon('heroicon-o-user-plus')
                ->description('Son 24 saat')
                ->color('green')
                ->chart(
                    $this->getUserRegistrationData()
                ),
            Stat::make('Öğrenciler', User::whereHas('roles', function ($query) {
                $query->where('slug', 'ogrenci');
            })->count())
                ->icon('heroicon-o-academic-cap')
                ->description('Gazi Üniversitesi öğrencileri')
                ->color('blue')
                ->chart(
                    $this->getStudentRegistrationData()
                ),
            Stat::make('Toplam Kullanıcılar', User::count())
                ->icon('heroicon-o-users')
                ->description('Toplam kayıtlı kullanıcılar')
                ->color('amber')
                ->chart(
                    $this->getTotalUserGrowthData()
                ),
        ];
    }

    protected function getUserRegistrationData(): array
    {
        $data = [];

        // Get data for the last 24 hours in hourly intervals
        for ($i = 23; $i >= 0; $i--) {
            $hour = now()->subHours($i);
            $count = User::whereBetween('created_at', [
                $hour->copy()->startOfHour(),
                $hour->copy()->endOfHour(),
            ])->count();
            $data[] = $count;
        }

        return $data;
    }

    protected function getStudentRegistrationData(): array
    {
        $data = [];

        // Get data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = User::whereHas('roles', function ($query) {
                $query->where('slug', 'ogrenci');
            })->whereDate('created_at', $date)->count();
            $data[] = $count;
        }

        return $data;
    }

    protected function getTotalUserGrowthData(): array
    {
        $data = [];

        // Get cumulative data for the last 7 days
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = User::whereDate('created_at', '<=', $date)->count();
            $data[] = $count;
        }

        return $data;
    }
}
