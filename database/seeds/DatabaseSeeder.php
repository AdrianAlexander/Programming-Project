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
        $faker = Faker::create();
        $faker->addProvider(new \MattWells\Faker\Vehicle\Provider($faker));

        foreach (range(1,15) as $index) {
	        DB::table('users')->insert([
	            'name' => $faker->name,
	            'email' => $faker->email,
	            'password' => Hash::make("secret"),
	        ]);

	        DB::table('cars')->insert([
	        	'car_name' => $faker->vehicleMake,
        		'car_type' => $faker->vehicleModel,
        		'plate_number' => $faker->vehicleLicensePlate,
        		'fuel' => $faker->numberBetween(30, 50),
        		'description' => 'this is a car',
        		'price' => $faker->numberBetween(15, 40),
        		'longitude' => 145.101363,
        		'latitude' => -37.588756,
        		'image' => 'http://car.com',
	        ]);
    	}
	}
}