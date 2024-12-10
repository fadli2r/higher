<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->formatStateUsing(fn ($record) => \Str::upper($record->order_status))
                    ->description(fn ($record): string => (!$record->transaction) ? 'Belum Ada Transaksi' : $record->transaction->invoice_number)
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                // Filter berdasarkan user yang sedang login
            Tables\Filters\Filter::make('user_id')
            ->label('My Orders')
            ->query(fn (Builder $query) => $query->where('user_id', auth()->id())) // Use auth()->id() directly

            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('createInvoice')
                    ->label('Bayar') // Button label
                    ->color('primary') // Button color
                    ->icon('heroicon-o-credit-card') // Optional: Icon
                    ->url(fn ($record) => ($record->transaction->invoice_url) ?? route('cart.createInvoice', $record->id)) // Custom route
                    ->openUrlInNewTab(), // Optional: Open in new tab
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
