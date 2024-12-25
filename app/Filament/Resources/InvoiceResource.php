<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('invoice_number')
                    ->label('Invoice Number')
                    ->required()
                    ->disabled(),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Customer')
                    ->required(),

                Forms\Components\TextInput::make('total_amount')
                    ->label('Total Amount')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),

                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                        'failed' => 'Failed',
                    ])
                    ->label('Payment Status')
                    ->required(),

                Forms\Components\DateTimePicker::make('due_date')
                    ->label('Due Date')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Notes')
                    ->rows(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('invoice_number')->sortable()->searchable(),
            TextColumn::make('user.name')->label('Customer')->searchable(),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'secondary' => 'pending',
                    'success' => 'paid',
                    'danger' => 'failed',
                ])
                ->sortable(),

            TextColumn::make('total_amount')->money('IDR', true),
            TextColumn::make('due_date')->date()->sortable(),
        ])
        ->actions([
            Action::make('show')
                ->label('Show Invoice')
                ->url(fn (Invoice $record): string => route('invoices.show', $record))
                ->openUrlInNewTab(),
            Action::make('download')
    ->label('Download Invoice')
    ->url(fn (Invoice $record): string => route('invoices.download', $record))
    ->openUrlInNewTab(),

        ])
        ->filters([
            //
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
