<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdukResource\Pages;
use App\Models\Produk;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationLabel = 'Produk Digital';
    protected static ?string $navigationGroup = 'Manajemen Produk';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Nama_Produk')->required(),
                Forms\Components\Textarea::make('Deskripsi'),
                Forms\Components\TextInput::make('Harga')->numeric()->required(),
                Forms\Components\TextInput::make('Stok')->numeric(),
                Forms\Components\Select::make('Kategori')
                    ->options([
                        'Logo' => 'Logo',
                        'UI Design' => 'UI Design',
                        'Illustration' => 'Illustration',
                        'Animation' => 'Animation',
                    ])->required(),
                Forms\Components\Select::make('Status_Produk')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Tidak Tersedia' => 'Tidak Tersedia',
                    ])->required(),
                Forms\Components\TextInput::make('Durasi')
                    ->numeric()
                    ->label('Durasi (hari)')
                    ->placeholder('Estimasi durasi dalam hari'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Nama_Produk')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('Harga')->sortable(),
                Tables\Columns\TextColumn::make('Stok')->sortable(),
                Tables\Columns\TextColumn::make('Kategori')->sortable(),
                Tables\Columns\TextColumn::make('Status_Produk')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->date('d-m-Y')->label('Dibuat Pada')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('Kategori')
                    ->options([
                        'Logo' => 'Logo',
                        'UI Design' => 'UI Design',
                        'Illustration' => 'Illustration',
                        'Animation' => 'Animation',
                    ]),
                Tables\Filters\SelectFilter::make('Status_Produk')
                    ->options([
                        'Tersedia' => 'Tersedia',
                        'Tidak Tersedia' => 'Tidak Tersedia',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
