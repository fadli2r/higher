<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers\MessageRelationManager;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Member';

    public static function form(Form $form): Form
{
    return $form->schema([
        Forms\Components\TextInput::make('title')
            ->label('Title')
            ->required()
            ->maxLength(255),
        Forms\Components\Select::make('status')
            ->label('Status')
            ->options([
                'open' => 'Open',
                'in-progress' => 'In Progress',
                'closed' => 'Closed',
            ])
            ->required(),
        Forms\Components\Repeater::make('messages') // Gunakan nama relasi di model Ticket
            ->relationship('messages') // Relasi ke model TicketMessage
            ->schema([
                Forms\Components\Grid::make(1) // Gunakan grid untuk layout
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->label('Reply')
                            ->rows(5) // Tinggi area input
                            ->required(),
                        Forms\Components\Select::make('sender_type')
                            ->options([
                                'user' => 'User',
                                'admin' => 'Admin',
                            ])
                            ->default('admin') // Default admin sebagai pengirim
                            ->required()
                            ->label('Sender Type'),
                    ]),
            ])
            ->createItemButtonLabel('Add Reply') // Label tombol
            ->disableItemDeletion(), // Nonaktifkan penghapusan
    ])->columns(1);
}


    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')
                ->label('Title')
                ->sortable()
                ->searchable(),
            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'primary' => 'open',
                    'warning' => 'in-progress',
                    'success' => 'closed',
                ]),
            Tables\Columns\TextColumn::make('user.name')
                ->label('Customer')
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime(),
        ]);
    }
    public static function saved($record, $state): void
    {
        logger('State:', $state); // Debugging untuk melihat data yang diterima

        if (isset($state['new_messages'])) {
            foreach ($state['new_messages'] as $message) {
                logger('Saving message:', $message); // Debug data pesan sebelum menyimpannya
                $record->messages()->create([
                    'message' => $message['message'],
                    'sender_type' => $message['sender_type'],
                    'sender_id' => auth()->id(), // ID pengirim
                ]);
            }
        }
    }



    public static function getRelations(): array
    {
        return [
            MessageRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
