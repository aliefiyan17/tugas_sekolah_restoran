<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'namalengkap' => 'Administrator',
                'email' => 'admin@kasir.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrator',
            ],
            [
                'name' => 'Waiter',
                'username' => 'waiter1',
                'namalengkap' => 'Abyan',
                'email' => 'waiter1@kasir.com',
                'password' => Hash::make('waiter123'),
                'role' => 'waiter',
            ],
            [
                'name' => 'Kasir',
                'username' => 'kasir1',
                'namalengkap' => 'Hibat',
                'email' => 'kasir1@kasir.com',
                'password' => Hash::make('kasir123'),
                'role' => 'kasir',
            ],
            [
                'name' => 'Owner',
                'username' => 'owner',
                'namalengkap' => 'Alief',
                'email' => 'owner@kasir.com',
                'password' => Hash::make('owner123'),
                'role' => 'owner',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}