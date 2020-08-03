<?php

use Faker\Generator as Faker;
use App\Car;

$factory->define(App\Car::class, function (Faker $faker) {
	$faker->addProvider(new \MattWells\Faker\Vehicle\Provider($faker));
    return [
        'car_name' => $faker->vehicleMake,
        'car_type' => $faker->vehicleModel,
       	'plate_number' => $faker->vehicleLicensePlate,
       	'fuel' => $faker->numberBetween(30, 50),
       	'description' => 'mobil kentang',
       	'price' => $faker->numberBetween(15, 40),
       	'longitude' => 145.101363,
       	'latitude' => -37.588756,
       	'image' => 'http://mobilkentang.com',
    ];
});
