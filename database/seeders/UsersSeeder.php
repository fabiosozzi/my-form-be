<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super-admin@example.it',
            'password' => bcrypt('password')
        ]);

        $superAdmin->assignRole('super-admin');

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.it',
            'password' => bcrypt('password')
        ]);
    }
}
