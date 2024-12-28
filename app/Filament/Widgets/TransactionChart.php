<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use App\Models\Transaction;

class TransactionChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Transaction Statistics';
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

        // Ambil data transaksi menggunakan Flowframe Trend
        $data = Trend::model(Transaction::class)
            ->between(start: $start, end: $end)
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Transactions',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#4CAF50',
                    'backgroundColor' => 'rgba(76, 175, 80, 0.1)',
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
