<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\Widgets\TransactionOverview;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\Action;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;
    protected static ?string $navigationGroup = 'Transaksi';
    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('order_id')
                ->label('ID Pesanan')
                ->required(),
            Forms\Components\Select::make('payment_status')
                ->label('Status Pembayaran')
                ->options([
                    'pending' => 'Menunggu',
                    'paid' => 'Dibayar',
                    'failed' => 'Gagal',
                ])
                ->required(),
            Forms\Components\TextInput::make('invoice_number')
                ->label('Nomor Invoice'),
            Forms\Components\TextInput::make('invoice_url')
                ->label('URL Invoice'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('Transaction ID')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('User Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Payment Status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'completed',
                        'danger' => 'failed',
                    ]),
                TextColumn::make('total_price')
                    ->label('Total Price')
                    ->money('IDR'), // Format sebagai mata uang
                Tables\Columns\BooleanColumn::make('is_subscription_payment')
                    ->label('Subscription Payment'),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime(),
            ])
            ->actions([
                Action::make('show_invoice')
                    ->label('Show Invoice') // Label tombol
                    ->icon('heroicon-o-document-text') // Ikon tombol
                    ->url(fn ($record) => $record->invoice_url) // URL faktur
                    ->openUrlInNewTab(), // Buka di tab baru
            ])
            ->filters([
                SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'failed' => 'Failed',
                    ])
                    ->label('Filter by Payment Status'),
                Filter::make('is_subscription_payment')
                    ->query(fn ($query) => $query->where('is_subscription_payment', true))
                    ->label('Subscription Payments Only'),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('to')
                            ->label('To Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['to'], fn ($q) => $q->whereDate('created_at', '<=', $data['to']));
                    })
                    ->label('Filter by Date'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getWidgets(): array
{
    return [
        \App\Filament\Resources\TransactionResource\Widgets\TransactionOverview::class,
    ];
}


    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
