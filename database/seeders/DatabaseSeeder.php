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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // AL RILANCIO DEL SEEDERE SENZA UNO SPECIFICO, DB:SEED, VERRANNO RILANCIATI AUTOMATICAMNETE TUTTI I SEEDER DICHIARATI
        // $this->call([
        //     ProjectSeeder::class,
        //     TechnologySeeder::class,
        //     TypeSeeder::class,
        //     ProjectTechnologySeeder::class,
        // ]);
    }
}
