<?php

namespace App\Filament\Resources\JobDescResource\Pages;

use App\Filament\Resources\JobDescResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobDesc extends EditRecord
{
    protected static string $resource = JobDescResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
