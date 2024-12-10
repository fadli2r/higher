<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomRequestResource\Pages;
use App\Filament\Resources\CustomRequestResource\RelationManagers;
use App\Models\CustomRequest;
use App\Models\CustomItem;
use App\Models\CustomSize;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Navigation\NavigationItem;


class CustomRequestResource extends Resource
{
    protected static ?string $model = CustomRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static function getNavigation(): array
    {
        return [
            NavigationItem::make('Create Custom Request')
                ->url(route('order.custom')),  // Rute untuk Livewire component
            // Resource lainnya...
        ];
    }
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // Field untuk memilih desain
            Select::make('custom_item_id')
                ->label('Choose a Design')
                ->options(CustomItem::all()->pluck('name', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(function ($state, $set, $get) {
                    // Ambil harga dasar desain yang dipilih
                    $customItem = CustomItem::find($state);

                    // Set harga berdasarkan desain yang dipilih
                    $set('price', $customItem->base_price);
                }),

            // Field untuk memilih ukuran
            Select::make('custom_size_id')
                ->label('Choose a Size')
                ->options(CustomSize::all()->pluck('size_name', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(function ($state, $set, $get) {
                    // Ambil harga ukuran yang dipilih
                    $customSize = CustomSize::find($state);

                    // Ambil harga desain yang sudah dihitung sebelumnya
                    $price = $get('price');  // Mengambil nilai harga yang ada sebelumnya

                    // Tambahkan harga ukuran ke harga desain
                    $set('price', $price + $customSize->additional_price);  // Menetapkan harga baru
                }),

            // Field untuk menampilkan harga
            TextInput::make('price')
                ->label('Total Price')
                ->disabled(),  // Menonaktifkan field agar hanya bisa ditampilkan
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCustomRequests::route('/'),
            'create' => Pages\CreateCustomRequest::route('/create'),
            'edit' => Pages\EditCustomRequest::route('/{record}/edit'),
        ];
    }
}
