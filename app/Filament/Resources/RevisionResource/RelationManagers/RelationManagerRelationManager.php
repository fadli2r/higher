<?php

namespace App\Filament\Resources\RevisionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Revision;
use Filament\Tables\Columns\IconColumn;

class RelationManagerRelationManager extends RelationManager
{
    protected static string $relationship = 'RelationManager';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Revision')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('requested_by')
                    ->label('Diajukan Oleh')
                    ->formatStateUsing(fn($state) => \App\Models\User::find($state)->name ?? 'Tidak Diketahui'),

                    IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->options([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ])
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
