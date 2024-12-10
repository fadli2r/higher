<?php

namespace App\Filament\Resources\CustomSizeResource\Pages;

use App\Filament\Resources\CustomSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomSizes extends ListRecords
{
    protected static string $resource = CustomSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
