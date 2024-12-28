<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Filament\Resources\TicketResource\RelationManagers\MessageRelationManager;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->required()
                ->maxLength(255),
            Forms\Components\Select::make('status')
                ->options([
                    'open' => 'Open',
                    'in-progress' => 'In Progress',
                    'closed' => 'Closed',
                ])
                ->required(),
                Forms\Components\Repeater::make('messages')
    ->relationship('messages') // Relasi ke model messages
    ->schema([
        Forms\Components\Textarea::make('message')
            ->required()
            ->label('Message'),
        Forms\Components\Select::make('sender_type')
            ->options([
                'user' => 'User',
                'admin' => 'Admin',
            ])
            ->required()
            ->label('Sender Type'),
    ])
    ->disableItemDeletion() // Nonaktifkan penghapusan item
    ->createItemButtonLabel('Add Message') // Label tombol untuk menambah pesan
    ->saving(function ($component, $state) {
        foreach ($state as $messageData) {
            $component->getModelInstance()->messages()->create($messageData);
        }
    }),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
            Tables\Columns\BadgeColumn::make('status')
                ->label('Status')
                ->formatStateUsing(function ($state) {
                    return match ($state) {
                        'open' => 'Open',
                        'in-progress' => 'In Progress',
                        'closed' => 'Closed',
                        default => $state,
                    };
                })
                ->colors([
                    'primary' => fn ($state): bool => $state === 'open',
                    'warning' => fn ($state): bool => $state === 'in-progress',
                    'success' => fn ($state): bool => $state === 'closed',
                ]),

            Tables\Columns\TextColumn::make('user.name')->label('Customer'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ]);
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
