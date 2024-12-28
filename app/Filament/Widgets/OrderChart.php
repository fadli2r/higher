<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Order;

class OrderChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Order Statistics';
    protected static ?string $pollingInterval = null; // Optional: Enable auto-refresh

    public ?string $filter = 'month'; // Default filter

    protected function getData(): array
    {
        // Ambil filter aktif
        $activeFilter = $this->filter;

        // Tentukan periode waktu berdasarkan filter
        $start = match ($activeFilter) {
            'today' => now()->startOfDay(),
            'week' => now()->subWeek()->startOfWeek(),
            'month' => now()->startOfMonth(),
            'year' => now()->startOfYear(),
            default => now()->startOfMonth(), // Default ke awal bulan
        };

        $end = match ($activeFilter) {
            'today' => now()->endOfDay(),
            'week' => now()->endOfWeek(),
            'month' => now()->endOfMonth(),
            'year' => now()->endOfYear(),
            default => now()->endOfMonth(), // Default ke akhir bulan
        };

        // Ambil data menggunakan Flowframe Trend
        $data = Trend::model(Order::class)
            ->between(start: $start, end: $end)
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
        // Filter yang tersedia
        return [
            'today' => 'Today',
            'week' => 'Last Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Tipe chart
    }
}
