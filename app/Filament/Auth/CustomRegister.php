<?php

namespace App\Filament\Auth;

use Filament\Pages\Auth\Register;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms;

class CustomRegister extends Register
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        Forms\Components\TextInput::make('whatsapp')
                            ->tel() // Ensure it uses the "tel" input type for phone numbers
                            ->required()
                            ->label('Whatsapp Number')
                            ->maxLength(15),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): Model
    {
        return $this->getUserModel()::create($data);
        $user = $this->getUserModel()::create($data);
        $user->assignRole('panel_user');

        return $user;
    }
}
