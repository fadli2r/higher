<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingsForm extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    // Inisialisasi properti dengan data pengguna yang sedang login
    public function mount()
    {
        $user = auth()->user();  // Mengambil objek pengguna yang sedang login
        $this->name = $user->name;
        $this->email = $user->email;
    }

    // Validasi inputan dan simpan perubahan
    public function saveSettings()
    {
        // Validasi inputan
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|confirmed|min:8',  // Validasi password dan konfirmasi
        ]);

        // Ambil pengguna yang sedang login
        $user = auth()->user();

        // Update data pengguna
        $user->name = $this->name;
        $user->email = $this->email;

        // Jika password diubah, enkripsi dan simpan password baru
        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        // Tampilkan pesan sukses
        session()->flash('success', 'Pengaturan berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.settings-form');
    }
}

