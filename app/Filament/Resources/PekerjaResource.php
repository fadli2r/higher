<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PekerjaResource\Pages;
use App\Filament\Resources\PekerjaResource\RelationManagers;
use App\Models\Pekerja;
use App\Models\JobDesc;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PekerjaResource extends Resource
{
    protected static ?string $model = Pekerja::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected $fillable = ['name', 'user_id', 'job_descs_id'];

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Name'),
                Forms\Components\Select::make('job_descs_id')
                    ->label('Job Description')
                    ->relationship('jobDesc', 'name') // Mengambil nama deskripsi pekerjaan dari relasi
                    ->options(\App\Models\JobDesc::pluck('name', 'id')->toArray()) // Mengambil opsi dari tabel job_descs
                    ->required()
                    ->searchable()
                    ->default(fn ($record) => $record->job_descs_id) // Default sesuai dengan nilai yang ada di record
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
