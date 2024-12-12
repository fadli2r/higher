<?php

namespace App\Filament\Resources\WorkerTaskResource\Pages;

use App\Filament\Resources\WorkerTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorkerTasks extends ListRecords
{
    protected static string $resource = WorkerTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
