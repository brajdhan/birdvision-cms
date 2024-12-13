<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // Admin User
        // User::factory()->create([
        //     'name' => 'Admin User',
        //     'email' => 'admin@bird.com',
        //     'password' => bcrypt('password'),
        //     'role' => 'admin',
        // ]);

        // Sale Manager User
        // User::factory()->create([
        //     'name' => 'Sale Manager User',
        //     'email' => 'salemanager@bird.com',
        //     'password' => bcrypt('password'),
        //     'role' => 'sales_manager',
        // ]);

        $this->call([
            SaleSeeder::class,
        ]);
    }
}
