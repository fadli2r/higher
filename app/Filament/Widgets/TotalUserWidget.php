<?php

namespace App\Filament\Widgets;

use App\Models\Pekerja;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalUserWidget extends BaseWidget
{

    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
            ->description('Pengguna')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart(User::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('count')->toArray())
                        ->color('success'),
            Stat::make('Total Users', Pekerja::count())
            ->description('Jumlah pekerja aktif')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1, 2, 10, 3, 15, 4, 17])
            ->color('success'),
            Stat::make('Total Member', User::where('membership_status', 'member')->count())
            ->description('Jumlah member aktif')
            ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
            ->chart([1, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }

}
