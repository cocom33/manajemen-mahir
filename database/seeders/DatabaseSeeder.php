<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'asd@gmail.com',
            'password' => bcrypt('asd'),
            'email_verified_at' => Date('now'),
        ]);

        $this->call([
            ClientSeeder::class,
            ProjectTypeSeeder::class,
            TeamSeeder::class,
        ]);
    }
}