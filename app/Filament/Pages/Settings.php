<?php

namespace App\Filament\Pages;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\PasswordInput;
use Filament\Forms\Components\Button;
use Illuminate\Support\Facades\Hash;

use Filament\Pages\Page;

class Settings extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Setting';

    protected static string $view = 'filament.pages.settings';


}
