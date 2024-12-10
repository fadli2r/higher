<?php

namespace App\Filament\Resources\CustomSizeResource\Pages;

use App\Filament\Resources\CustomSizeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomSize extends EditRecord
{
    protected static string $resource = CustomSizeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
