<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\ProductWorkflow;

class WorkflowRelationManager extends RelationManager
{
    protected static string $relationship = 'workflows';  // Pastikan nama relasi sesuai dengan nama fungsi di model Product
    protected static ?string $recordTitleAttribute = 'step_name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('step_name')
                ->required()
                ->label('Step Name'),
            Forms\Components\TextInput::make('step_order')
                ->numeric()
                ->required()
                ->label('Step Order'),
            Forms\Components\TextInput::make('step_duration')
                ->numeric()
                ->required()
                ->label('Duration (Days)'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('step_name')->label('Step Name'),
                Tables\Columns\TextColumn::make('step_order')->label('Order'),
                Tables\Columns\TextColumn::make('step_duration')->label('Duration (Days)'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    protected function getActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()  // Menambahkan tombol tambah
                ->label('Add Step')
                ->icon('heroicon-o-plus')
                ->action(function () {
                    // Logic untuk membuat langkah baru
                }),
        ];
    }
}
