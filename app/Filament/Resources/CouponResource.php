<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->label('Kode Kupon')
                    ->required()
                    ->unique(Coupon::class, 'code')
                    ->maxLength(255),
                Forms\Components\TextInput::make('discount_value')
                    ->label('Nilai Diskon')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('discount_type')
                    ->label('Jenis Diskon')
                    ->options([
                        'fixed' => 'Fixed',
                        'percentage' => 'Percentage',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('expires_at')
                    ->label('Tanggal Kadaluarsa')
                    ->required()
                    ->afterOrEqual(now()),
                Forms\Components\Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('code')
                ->label('Kode Kupon')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('discount_value')
                ->label('Nilai Diskon')
                ->formatStateUsing(fn ($state) => $state . ' ' . 'IDR'),
            Tables\Columns\TextColumn::make('discount_type')
                ->label('Jenis Diskon')
                ->sortable(),
            Tables\Columns\TextColumn::make('expires_at')
                ->label('Kadaluarsa')
                ->date(),
            Tables\Columns\BooleanColumn::make('is_active')
                ->label('Aktif'),
        ])
        ->filters([

        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
