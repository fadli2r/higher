<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create the 'panel_user' role if it doesn't exist
        Role::firstOrCreate(['name' => 'panel_user']);

        $this->call([
            RoleSeeder::class,
            // other seeders can be added here if needed
        ]);
    }
}
