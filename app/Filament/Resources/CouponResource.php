<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CouponResource\Pages;
use App\Filament\Resources\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Actions\Modal\Actions\Action;
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
                Forms\Components\TextInput::make('max_discount_value')
                    ->label('Diskon Maksimal (IDR)')
                    ->numeric()
                    ->placeholder('Contoh: 50000'),
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
                    ->formatStateUsing(fn ($state, $record) => $record->discount_type === 'fixed' ? $state . ' IDR' : $state . '%'),
                Tables\Columns\TextColumn::make('discount_type')
                    ->label('Jenis Diskon')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_discount_value')
                ->label('Diskon Maksimal (IDR)'),
                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Kadaluarsa')
                    ->date(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status Aktif')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ]),
                Tables\Filters\Filter::make('expired')
                    ->query(fn (Builder $query) => $query->where('expires_at', '<', now()))
                    ->label('Sudah Kadaluarsa'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('regenerate')
                ->label('Regenerate')
                ->color('primary')
                ->action(function (Coupon $record) {
                    $newCoupon = $record->replicate();
                    $newCoupon->code = $record->code . '-' . now()->timestamp; // Generate kode baru
                    $newCoupon->expires_at = now()->addDays(30); // Tanggal kadaluarsa baru
                    $newCoupon->is_active = true;
                    $newCoupon->save();

                    session()->flash('success', "Coupon '{$newCoupon->code}' berhasil dibuat dengan ID baru.");
                })
                ->visible(fn (Coupon $record) => !$record->is_active || $record->expires_at < now()),
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
