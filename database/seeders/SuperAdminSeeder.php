<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('role', 'SuperAdmin')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@urlshortner.com',
                'password' => Hash::make('12345678'),
                'role' => 'SuperAdmin',
                'company_id' => null,
            ]);

            $this->command->info('SuperAdmin created successfully!');
        } else {
            $this->command->info('SuperAdmin already exists.');
        }
    }
}
