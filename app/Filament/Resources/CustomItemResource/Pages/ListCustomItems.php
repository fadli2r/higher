<?php

namespace App\Filament\Resources\CustomItemResource\Pages;

use App\Filament\Resources\CustomItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomItems extends ListRecords
{
    protected static string $resource = CustomItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
