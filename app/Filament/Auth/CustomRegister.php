<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;

class CustomRegister extends Register
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    protected function handleRegistration(array $data): Model
    {
        return $this->getUserModel()::create($data);
        $user = $this->getUserModel()::create($data);
        $user->assignRole('panel_user');

        return $user;
    }
}
