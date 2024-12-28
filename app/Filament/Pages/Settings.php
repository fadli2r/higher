<?php

namespace App\Filament\Pages;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\PasswordInput;
use Filament\Forms\Components\Button;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

use Filament\Pages\Page;

class Settings extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Setting';

    protected static string $view = 'filament.pages.settings';
    public function mount()
    {
        return Redirect::to(route('edit-profile')); // Pastikan route ini mengarah ke product.index
    }

}
