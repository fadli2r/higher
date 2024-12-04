<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\{User, JobDesc};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Pekerja;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Member';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Using Select Component
                // Menambahkan detail akun yang akan dibuat bersamaan
                Forms\Components\TextInput::make('pekerja.name')
                    ->label('Name')
                    ->required(),

                Forms\Components\Select::make('pekerja.job_descs_id')
                    ->label('Deskripsi Pekerjaan')

                    ->options(\App\Models\JobDesc::pluck('name', 'id')->toArray())
                    ->required()
                    ->searchable()
                    ->placeholder('Pilih Deskripsi Pekerjaan'),

                Forms\Components\Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
            $data = $request->validate([
                'pekerja.name' => 'required|string|max:255',
                'pekerja.job_descs_id' => 'required|exists:job_descs,id',
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    protected function afterCreate(array $data, $user): void
    {
        $user->pekerja()->update([
            'user_id' => $user->id,
        ]);
    }

    protected static function mutateFormDataBeforeCreate(array $data): array
    {
        // Buat entri di tabel pekerja
        $pekerja = Pekerja::create([
            'name' => $data['pekerja']['name'] ?? $data['name'],
            'job_descs_id' => $data['pekerja']['job_descs_id'],
            'user_id' => null, // Akan diisi setelah user dibuat
        ]);

        // Tambahkan ID pekerja ke data user, jika relasi memerlukan pekerja_id
        $data['pekerja_id'] = $pekerja->id;

        return $data;
    }
}
