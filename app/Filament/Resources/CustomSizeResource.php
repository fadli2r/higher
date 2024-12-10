<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomSizeResource\Pages;
use App\Filament\Resources\CustomSizeResource\RelationManagers;
use App\Models\CustomSize;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput as NumericTextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomSizeResource extends Resource
{
    protected static ?string $model = CustomSize::class;
    protected static ?string $navigationGroup = 'Design Custom';
    protected static ?int $navigationSort = 3;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('size_name')
                ->label('Size Name')
                ->required()
                ->maxLength(255),

            NumericTextInput::make('additional_price')
                ->label('Additional Price')
                ->numeric()
                ->required(),

            Textarea::make('description')
                ->label('Description')
                ->nullable()
                ->maxLength(500),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('size_name')->label('Size Name'),
                TextColumn::make('additional_price')->label('Additional Price'),
                TextColumn::make('description')->label('Description'),
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
            'index' => Pages\ListCustomSizes::route('/'),
            'create' => Pages\CreateCustomSize::route('/create'),
            'edit' => Pages\EditCustomSize::route('/{record}/edit'),
        ];
    }
}
