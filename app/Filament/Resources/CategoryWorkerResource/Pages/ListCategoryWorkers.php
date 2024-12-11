<?php

namespace App\Filament\Resources\CategoryWorkerResource\Pages;

use App\Filament\Resources\CategoryWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryWorkers extends ListRecords
{
    protected static string $resource = CategoryWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
