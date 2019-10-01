<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for($x=0; $x<=50; $x++){
        	$car = factory(\App\Car::class)->create(); 
        	$user = factory(\App\User::class)->create();
        }
    }
}
