<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str; //importazione sluge

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // disable foreign key constraints to avoid integrity errors
        Schema::disableForeignKeyConstraints();

        // clear the table
        Technology::truncate();

        //starts array 
        $technologies= [ 'HTML', 'CSS', 'VUE', 'PHP', 'JAVASCRIPT', 'SQL', 'MYSQL', 'LARAVEL', 'AXIOS' ];
        
        // insert data into the table
        foreach ($technologies as $technology) {
            //new instance
            $newTechnology = new Technology();
            $newTechnology->title = $technology;
            $newTechnology->slug = Str::of($technology)->slug();

            //save record
            $newTechnology->save();
        }

        
        //enable foreign key constraints to avoid integrity errors
        Schema::enableForeignKeyConstraints();

    }
}
