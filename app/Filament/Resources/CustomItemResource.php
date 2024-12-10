<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomItemResource\Pages;
use App\Filament\Resources\CustomItemResource\RelationManagers;
use App\Models\CustomItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;  // Import yang benar
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomItemResource extends Resource
{
    protected static ?string $model = CustomItem::class;
    protected static ?string $navigationGroup = 'Design Custom';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('name')
                ->label('Design Name')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->label('Description')
                ->required()
                ->maxLength(500),

            TextInput::make('base_price')
                ->label('Base Price')
                ->numeric()
                ->required(),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Design Name'),
                TextColumn::make('base_price')->label('Base Price'),
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
            'index' => Pages\ListCustomItems::route('/'),
            'create' => Pages\CreateCustomItem::route('/create'),
            'edit' => Pages\EditCustomItem::route('/{record}/edit'),
        ];
    }
}
