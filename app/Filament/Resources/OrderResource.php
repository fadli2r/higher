<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?array $with = ['customRequest'];

    public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery()->with('customRequest');
}

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            // User Select: Admin can choose a user for the order (optional)
            Select::make('user_id')
                ->label('User')
                ->disabled()
                ->relationship('user', 'name') // Assumes `Order` has a `user()` relationship defined
                ->required(),

            // Total Price: Admin can edit the total price of the order
            TextInput::make('total_price')
                ->label('Total Price')
                ->numeric()
                ->disabled()
                ->required(),

            // Order Status: Admin can choose the order status (pending, completed, etc.)
            Select::make('order_status')
                ->label('Order Status')
                ->options([
                    'pending' => 'Pending',
                    'in_progress' => 'Proses',
                    'completed' => 'Completed',
                    'canceled' => 'Canceled',
                ])
                ->disabled()
                ->required(),

                Forms\Components\Fieldset::make('Custom Request Details')
                ->schema([
                        Forms\Components\Placeholder::make('customRequestDetails')
                        ->label('Nama Custom')
                        ->content(fn ($record) => $record->customRequest->name ?? 'No Data Available'),
                        Forms\Components\Placeholder::make('customRequestDetails')
                        ->label('Nama Brand')
                        ->content(fn ($record) => $record->customRequest->brand_name ?? 'No Data Available'),
                        Forms\Components\Placeholder::make('customRequestDetails')
                        ->label('Nomor Whatsapp')
                        ->content(fn ($record) => $record->customRequest->whatsapp ?? 'No Data Available'),
                        Forms\Components\Placeholder::make('customRequestDetails')
                        ->label('Deskripsi')
                        ->content(fn ($record) => $record->customRequest->description ?? 'No Data Available'),

                        Forms\Components\Placeholder::make('customRequestDetails')
                        ->label('Arahan')
                        ->content(fn ($record) => $record->customRequest->direction ?? 'No Data Available'),
                        Forms\Components\Placeholder::make('customRequestDetails')
                        ->label('Warna Rekomendasi')
                        ->content(fn ($record) => $record->customRequest->color_recommendation ?? 'No Data Available'),

                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('Download Referensi Desain')
                                ->url(function ($record) {
                                    if ($record->customRequest && $record->customRequest->design_reference) {
                                        return asset('storage/' . $record->customRequest->design_reference);
                                    }
                                    return null;
                                })
                                ->label('Unduh Referensi Desain')
                                ->color('primary') // Warna tombol
                                ->visible(function ($record) {
                                    return $record->customRequest && $record->customRequest->design_reference;
                                }),
                        ])

                ])


                ->visible(fn ($record) => $record && $record->customRequest), // Hanya tampil jika ada customRequest.

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('Order ID')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('product.title')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function ($record) {
                        if ($record->product_id) {
                            return $record->product->title;
                        }

                        if ($record->custom_request_id) {
                            return $record->customRequest->name;
                        }

                        return 'Tidak Diketahui';
                    }),
                    Tables\Columns\TextColumn::make('worker.name')
                ->label('Worker')
                ->sortable()
                ->searchable()
                ->placeholder('Belum ada pekerja'), // Tampilkan placeholder jika belum diassign

                Tables\Columns\TextColumn::make('order_status')
                    ->formatStateUsing(fn ($record) => \Str::upper($record->order_status))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->searchable()
            ])
            ->filters([
                Tables\Filters\Filter::make('my_orders')
                    ->label('My Orders')
                    ->query(function (Builder $query) {
                        if (auth()->user()->hasRole('panel_pekerja')) {
                            $pekerjaId = auth()->user()->pekerja?->id; // Ambil ID pekerja dari user yang login
                            if ($pekerjaId) {
                                $query->where('worker_id', $pekerjaId);
                            }
                        }

                    })



                // Filter berdasarkan user yang sedang login

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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
