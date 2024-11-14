<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function afterSave()
    {
        // Menambahkan logika setelah menyimpan user, termasuk pembuatan detail akun
        $user = $this->record;

        dd($user);

        $user->pekerja()->create([
            'name' => $this->form->getState()['pekerja']['name'],
            'job_desc_id' => $this->form->getState()['pekerja']['job_desc_id'],
        ]);
    }
}
