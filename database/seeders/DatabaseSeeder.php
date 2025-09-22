<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default users only if they don't exist
        $users = [
            [
                'name'      => 'admin',
                'email'     => 'admin@admin.com',
                'role_type' => 'Admin',
                'password'  => 'admin@chamara',
            ],
            [
                'name'      => 'manager',
                'email'     => 'manager@manager.com',
                'role_type' => 'Manager',
                'password'  => 'manager@chamara',
            ],
            [
                'name'      => 'cashier',
                'email'     => 't1@cashier.com',
                'role_type' => 'Cashier',
                'password'  => 'cashier@chamara',
            ],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['email' => $u['email']], // lookup
                [
                    'name'      => $u['name'],
                    'role_type' => $u['role_type'],
                    'password'  => Hash::make($u['password']),
                ] // only used on create
            );
        }

        // Run other seeders
        $this->call([
            ColoranceStockSeeder::class,
            // ColorSeeder::class,
            // SizeSeeder::class,
        ]);
    }
}
