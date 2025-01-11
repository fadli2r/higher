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
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'Member';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form->schema([
        // Nama pengguna
        Forms\Components\TextInput::make('name')
            ->label('Nama Pengguna')
            ->required()
            ->maxLength(255),

        // Email pengguna
        Forms\Components\TextInput::make('email')
            ->email()
            ->label('Email')
            ->required()
            ->maxLength(255),

        // Kata sandi pengguna
        Forms\Components\TextInput::make('password')
            ->label('Kata Sandi')
            ->password()
            ->required()
            ->maxLength(255),

        // Status member
        Forms\Components\Select::make('membership_status')
            ->label('Status Member')
            ->options([
                'member' => 'Member',
                'non_member' => 'Non Member',
            ])
            ->required(),

        // Peran pengguna
        Forms\Components\Select::make('roles')
            ->relationship('roles', 'name') // Hubungkan dengan roles melalui relasi
            ->multiple()
            ->preload()
            ->searchable()
            ->label('Roles'),
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
                    TextColumn::make('roles.name') // Ambil role melalui relasi
            ->label('Peran')
            ->formatStateUsing(function ($state) {
                // Jika pengguna memiliki role
                if ($state) {
                    return collect($state)
                        ->map(function ($role) {
                            // Map role ke nama yang sesuai
                            return match ($role) {
                                'panel_pekerja' => 'Pekerja',
                                'panel_user' => 'Anggota',
                                'panel_admin' => 'Mimin',

                                default => Str::title($role), // Capitalize untuk role lainnya
                            };
                        })->join(', '); // Gabungkan jika ada banyak role
                }

                // Jika tidak ada role
                return 'Tidak Ada Role';
            })
            ->sortable()
            ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('membership_status')
                    ->label('Status Member')
                    ->sortable()

                    ->searchable(),

            ])
            ->filters([
                //Tables\Filters\SelectFilter::make('membership_status')
                //->options([
                //    'member' => 'Member',
                //    'non_member' => 'Non Member',
                //])
                //->default('non_member'),

                Tables\Filters\SelectFilter::make('anggota')
            ->label('Hanya Anggota')
            // ->query(fn ($query) => $query->whereHas('roles', fn ($roleQuery) => $roleQuery->where('name', 'panel_user'))),
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
