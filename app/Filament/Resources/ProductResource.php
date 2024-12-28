<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Filament\Resources\ProductResource\RelationManagers\WorkflowRelationManager; // Pastikan ini mengimpor RelationManager yang benar
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationGroup = 'Products';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form

            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('Product Name'),
                    Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required()
                    ->label('Price')
                    ->columnSpan(2)
                    ,
                RichEditor::make('description')
                    ->label('Deskripsi')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->placeholder('Tulis deskripsi produk di sini...')
                    ->required()
                    ->columnSpan(3),

                Forms\Components\FileUpload::make('file_path')
                    ->label('File Path')
                    ->columnSpan(1)
                    ,
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->label('Category')
                    ->columnSpan(1)
                    ,
                Forms\Components\TextInput::make('estimated_days')
                    ->numeric()
                    ->disabled()  // Make it readonly, because it's calculated
                    ->label('Estimated Days')
                    ->columnSpan(1)
                    ,
                Forms\Components\Repeater::make('workflows')
                  // You can use Repeater for multiple workflow steps

                  ->relationship('workflows')  // Makes sure the relation is there
                    ->schema([
                        Forms\Components\TextInput::make('step_name')

                            ->required()
                            ->label('Step Name')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('step_order')
                            ->numeric()
                            ->required()
                            ->label('Step Order')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('step_duration')
                            ->numeric()
                            ->required()
                            ->label('Duration (Days)')
                            ->columnSpan(1),
                    ])
                    ->columnSpan(3)
                    ->label('Product Workflows')
            ]);



    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Product Name'),
                Tables\Columns\TextColumn::make('price')->label('Price'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')->date(),
                Tables\Columns\TextColumn::make('workflows.step_name')->label('Workflow Steps')
                ->getStateUsing(fn ($record) => $record->workflows->pluck('step_name')->join(', ')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\ProductResource\RelationManagers\WorkflowRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
