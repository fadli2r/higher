<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Support\Facades\Redirect;

class Katalog extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Products';

    protected static string $view = 'filament.pages.katalog';
    public function mount()
    {
        return Redirect::to(route('products.index')); // Pastikan route ini mengarah ke product.index
    }
}
