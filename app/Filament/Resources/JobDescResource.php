<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobDescResource\Pages;
use App\Filament\Resources\JobDescResource\RelationManagers;
use App\Models\JobDesc;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobDescResource extends Resource
{
    protected static ?string $model = JobDesc::class;
    protected static ?string $navigationGroup = 'Pekerja';

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
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
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
            'index' => Pages\ListJobDescs::route('/'),
            'create' => Pages\CreateJobDesc::route('/create'),
            'edit' => Pages\EditJobDesc::route('/{record}/edit'),
        ];
    }
}
