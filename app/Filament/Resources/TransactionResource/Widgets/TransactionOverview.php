<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Transaction;

class TransactionOverview extends BaseWidget
{
    protected ?string $heading = 'Transaction Overview';

    protected function getCards(): array
    {
        // Total semua transaksi
        $totalTransactions = Transaction::count();

        // Total pendapatan dari transaksi yang sukses
        $successfulRevenue = Transaction::where('payment_status', 'completed')->sum('total_price');

        // Total transaksi sukses
        $successfulTransactions = Transaction::where('payment_status', 'completed')->count();

        return [
            Card::make('Total Transactions', $totalTransactions)
                ->description('Jumlah transaksi keseluruhan')
                ->descriptionIcon('heroicon-o-shopping-cart')
                ->color('primary'),

            Card::make('Successful Revenue', 'Rp ' . number_format($successfulRevenue, 0, ',', '.'))
                ->description('Pendapatan dari transaksi berhasil')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Card::make('Successful Transactions', $successfulTransactions)
                ->description('Jumlah transaksi berhasil')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
        ];
    }
}
