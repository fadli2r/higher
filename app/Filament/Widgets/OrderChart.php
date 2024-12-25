<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Order Statistics';
    protected static ?string $pollingInterval = null; // Optional: Enable auto-refresh

    public ?string $filter = 'today';
    public function getData(): array
    {
        $activeFilter = $this->filter;

        $data = Trend::model(Order::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#6366F1',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];

    }
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
    protected function getType(): string
    {
        return 'line';
    }
}
