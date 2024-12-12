<?php

namespace App\Filament\Resources\WorkerTaskResource\Pages;

use App\Filament\Resources\WorkerTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorkerTask extends EditRecord
{
    protected static string $resource = WorkerTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
