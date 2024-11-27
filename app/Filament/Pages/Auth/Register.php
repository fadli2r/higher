<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Page;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;  // Ensure User model is imported
use Spatie\Permission\Models\Role;

class Register extends BaseRegister
{
    // Define the registration form components
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    // Override the method to create the user and assign the 'panel_user' role
    protected function createUser(array $data): User
    {
        // Validate form data
        $validatedData = $this->validate();

        // Create the user from the validated data
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Retrieve the role 'panel_user' from the roles table
        $role = \Spatie\Permission\Models\Role::where('name', 'panel_user')->first();

        // If the role exists, assign it to the user
        if ($role) {
            $user->assignRole($role);
        }

        // Return the user after it's created and role is assigned
        return $user;
    }
}
