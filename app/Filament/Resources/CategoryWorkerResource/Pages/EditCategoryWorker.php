<?php

namespace App\Filament\Resources\CategoryWorkerResource\Pages;

use App\Filament\Resources\CategoryWorkerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryWorker extends EditRecord
{
    protected static string $resource = CategoryWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
