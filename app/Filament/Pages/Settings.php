<?php

namespace App\Filament\Pages;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

use Filament\Pages\Page;

class Settings extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';

}
