<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryWorkerResource\Pages;
use App\Filament\Resources\CategoryWorkerResource\RelationManagers;
use App\Models\CategoryWorker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Pekerja;  // Model Pekerja
use App\Models\Category;



class CategoryWorkerResource extends Resource
{
    protected static ?string $model = CategoryWorker::class;
    protected static ?string $navigationGroup = 'Pekerja';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // Pilih Kategori
            Forms\Components\Select::make('category_id')
                ->label('Category')
                ->options(Category::all()->pluck('name', 'id'))
                ->required(),

            // Pilih Pekerja
            Forms\Components\Select::make('worker_id')
                ->label('Worker')
                ->options(Pekerja::all()->pluck('name', 'id'))
                ->required(),

            // Tanggal penugasan
            Forms\Components\DateTimePicker::make('assigned_at')
                ->label('Assigned At')
                ->default(now())
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('category.name')->label('Category'),
            Tables\Columns\TextColumn::make('worker.name')->label('Worker'),
            Tables\Columns\TextColumn::make('assigned_at')->label('Assigned At'),
        ])
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCategoryWorkers::route('/'),
            'create' => Pages\CreateCategoryWorker::route('/create'),
            'edit' => Pages\EditCategoryWorker::route('/{record}/edit'),
        ];
    }
}
