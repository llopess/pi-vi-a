<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::query()->firstOrCreate(
            ['name' => 'Equipe Adopatinhas', 'password' => Hash::make('senha5')],
            ['email' => 'adm@adopatinhas.example'],

        );
        $this->call(AnimalSeeder::class);
    }
}
