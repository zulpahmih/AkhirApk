<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   
        // database/seeders/DatabaseSeeder.php
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            KelasSeeder::class,
            JurusanSeeder::class,
            KelasJurusanSeeder::class,
            WaliKelasSeeder::class,
            GuruSeeder::class,
        ]);
    }
 }
