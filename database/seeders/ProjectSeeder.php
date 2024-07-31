<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker; //importazione faker
use Illuminate\Support\Str; //importazione sluge

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 20; $i++) {

            //IMPORTAZIONE DEL MODELLO
            $project = new Project();

            $project->title = $faker->sentence(3);
            $project->description = $faker->paragraph(2);
            $project->slug = Str::of($project->title)->slug('-');



            $project->save();
        };
    }
}
