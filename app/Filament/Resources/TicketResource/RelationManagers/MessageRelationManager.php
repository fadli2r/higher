<?php

namespace App\Filament\Resources\TicketResource\RelationManagers;

use App\Models\TicketMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MessageRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('messages')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('message')
                ->label('Message')
                ->wrap(),
                Tables\Columns\BadgeColumn::make('sender_type')
                ->label('Sender')
                ->formatStateUsing(fn ($state) => $state === 'admin' ? 'Admin' : 'User') // Format label
                ->colors([
                    'success' => 'admin', // Warna hijau untuk admin
                    'primary' => 'user',  // Warna biru untuk user
                ]),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Sent At')
                ->dateTime(),
        ])->filters([]);
    }
    public static function getActions(): array
    {
        return [
            CreateAction::make('reply') // Aksi untuk balasan
                ->label('Reply to Ticket') // Label tombol
                ->form([
                    Forms\Components\Textarea::make('message')
                        ->label('Message')
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->messages()->create([
                        'sender_type' => 'admin',
                        'sender_id' => auth()->id(),
                        'message' => $data['message'],
                    ]);
                }),
        ];
    }
}
