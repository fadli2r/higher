<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PekerjaResource\Pages;
use App\Filament\Resources\PekerjaResource\RelationManagers;
use App\Models\Pekerja;
use App\Models\JobDesc;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PekerjaResource extends Resource
{
    protected static ?string $model = Pekerja::class;
    protected static ?string $navigationGroup = 'Pekerja';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected $fillable = ['name', 'user_id', 'job_descs_id'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
            ->label('Nama Pengguna')
            ->options(fn () => \App\Models\User::whereHas('roles', function ($query) {
                $query->where('name', 'panel_pekerja'); // Role yang diinginkan
            })->pluck('name', 'id'))
            ->searchable()
            ->required()
            ->placeholder('Pilih pengguna'),

        TextInput::make('name')
            ->label('Nama Pekerja')
            ->disabled() // Nonaktifkan input agar otomatis
            ->default(fn ($state) => $state && isset($state['user_id'])
                ? optional(\App\Models\User::find($state['user_id']))->name
                : null),

                Forms\Components\Select::make('job_descs_id')
                    ->label('Job Description')
                    ->relationship('jobDesc', 'name') // Mengambil nama deskripsi pekerjaan dari relasi
                    ->options(\App\Models\JobDesc::pluck('name', 'id')->toArray()) // Mengambil opsi dari tabel job_descs
                    ->required()
                    ->searchable()
                    ->placeholder('Pilih Deskripsi Pekerjaan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Name'),

                // Menambahkan kolom untuk Job Description
                Tables\Columns\TextColumn::make('jobDesc.name')
                    ->label('Job Description'),
            ])
            ->filters([
                Tables\Filters\Filter::make('panel_pekerja')
                    ->query(fn ($query) => $query->where('name', 'panel_pekerja'))
                    ->label('Panel Pekerja Roles'),
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
            'index' => Pages\ListPekerjas::route('/'),
            'create' => Pages\CreatePekerja::route('/create'),
            'edit' => Pages\EditPekerja::route('/{record}/edit'),
        ];
    }
}
