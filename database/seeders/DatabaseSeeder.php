<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Toqeer',
            'email' => 'toqeer32@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Ashir',
            'email' => 'ashir34@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        User::factory()->create([
            'name' => 'Waqas',
            'email' => 'waqas37@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
