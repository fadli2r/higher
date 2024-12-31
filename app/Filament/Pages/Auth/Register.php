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
        $user->assignRole('panel_user'); // Pastikan role sudah ada


        // Retrieve or create the role 'panel_user'
        $role = Role::firstOrCreate(
            ['name' => 'panel_user'], // Check for the role
            ['guard_name' => 'web']  // Create the role if it doesn't exist
        );

        // Assign the role to the user
        $user->assignRole($role);

        // redirect('/products')->send();

        // Return the user after it's created and role is assigned
        return $user;
    }
    protected function getRedirectUrl(): string
{
    return $this->previousUrl ?? $this->getResource()::getUrl('index');
}
}
