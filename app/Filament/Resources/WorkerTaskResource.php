<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkerTaskResource\Pages;
use App\Filament\Resources\WorkerTaskResource\RelationManagers;
use App\Models\WorkerTask;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TextFilter;
class WorkerTaskResource extends Resource
{
    protected static ?string $model = WorkerTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('task_description')
                    ->label('Task Description')
                    ->required(),

                Forms\Components\Select::make('progress')
                    ->label('Progress')
                    ->options([
                        'not_started' => 'Not Started',
                        'in_progress' => 'In Progress',
                        'revision_requested' => 'Revision Requested',
                        'completed' => 'Completed',
                    ])
                    ->required(),

                    FileUpload::make('file_path')
                    ->label('Upload File')
                    ->directory('uploads/tasks')
                    ->preserveFilenames()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('task_description')
                ->label('Task Description'),

            Tables\Columns\TextColumn::make('progress')
                ->label('Progress'),


            Tables\Columns\TextColumn::make('deadline')
                ->label('Deadline')
                ->date(),
        ])
        ->filters([
            // Apply filter based on worker_id for panel_pekerja
            SelectFilter::make('worker_id')
                ->label('Worker')
                ->options(function () {
                    return \App\Models\Pekerja::pluck('name', 'id')->toArray();
                })
                ->query(fn ($query) => $query->where('worker_id', auth()->user()->pekerja->id) )
                ->default(auth()->user()->pekerja->id)

        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\WorkerTaskRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkerTasks::route('/'),
            'create' => Pages\CreateWorkerTask::route('/create'),
            'edit' => Pages\EditWorkerTask::route('/{record}/edit'),
        ];
    }
}
