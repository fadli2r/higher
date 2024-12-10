<?php

namespace App\Filament\Resources\CustomItemResource\Pages;

use App\Filament\Resources\CustomItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomItem extends EditRecord
{
    protected static string $resource = CustomItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
