<?php

namespace App\Filament\Resources\CustomItemResource\Pages;

use App\Filament\Resources\CustomItemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomItem extends CreateRecord
{
    protected static string $resource = CustomItemResource::class;
}
