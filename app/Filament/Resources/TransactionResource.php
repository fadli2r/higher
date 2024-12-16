<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;

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
            TextColumn::make('id')->label('ID')->sortable(),
            TextColumn::make('order_id')->label('ID Pesanan')->sortable(),
            TextColumn::make('payment_status')
                ->label('Status Pembayaran')
                ->formatStateUsing(fn ($state) => match($state) {
                    'pending' => 'Menunggu',
                    'paid' => 'Dibayar',
                    'failed' => 'Gagal',
                    default => 'Tidak Diketahui',
                })
                ->sortable(),
            TextColumn::make('invoice_number')->label('Nomor Invoice'),
            TextColumn::make('created_at')
                ->label('Tanggal Transaksi')
                ->dateTime('d M Y H:i')
                ->sortable(),
        ])
        ->filters([
            SelectFilter::make('payment_status')
                ->label('Status Pembayaran')
                ->options([
                    'pending' => 'Menunggu',
                    'paid' => 'Dibayar',
                    'failed' => 'Gagal',
                ]),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
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
