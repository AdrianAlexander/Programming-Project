<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Car;

class CarTest extends TestCase
{
   

    use WithFaker;


    /** @test */
    public function createCar()
    {
    	$faker = (new \Faker\Factory())::create();
		$faker->addProvider(new \MattWells\Faker\Vehicle\Provider($faker));
    	//you can use this to create data manually
        $data = [
        	'car_name' => $faker->vehicleMake,
        	'car_type' => $faker->vehicleModel,
        	'plate_number' => $faker->vehicleLicensePlate,
        	'fuel' => $this->faker->numberBetween(30, 50),
        	'description' => 'mobil kentang',
        	'price' => $this->faker->numberBetween(15, 40),
        	'longitude' => 145.101363,
        	'latitude' => -37.588756,
        	'image' => 'http://mobilkentang.com',
        ];

        //use this to create new data using faker
        //$car = factory(\App\Car::class)->create(); 
        $response = $this->json('POST', '/api/cars',$data);
       
        $response->assertJson(["Successful!"]);

        
    }

    /** @test */
    public function showCar(){
    	$response = $this->json('GET', '/api/cars');
    	$product = $response->getData()[0];

    	$showCar = $this->json('GET', '/api/cars/'.$product->id);
    	$showCar->assertJsonStructure(
                [
                    [
                            'id',
                            'car_name',
                            'car_type',
                            'plate_number',
                            'fuel',
                            'price',
                            'longitude',
                            'latitude',
                            'image',
                            'taken',
                            'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    /** @test */
    public function getAllCar(){
    	$response = $this->json('GET', '/api/cars');
    	$response->assertJsonStructure(
                [
                    [
                            'id',
                            'car_name',
                            'car_type',
                            'plate_number',
                            'fuel',
                            'price',
                            'longitude',
                            'latitude',
                            'image',
                            'taken',
                            'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    /** @test */
    /*public function destroyCar(){
    	$response = $this->json('GET', '/api/cars');
    	$product = $response->getData()[0];



    	//$car = factory(\App\Car::class)->create();

    	$delete = $this->json('DELETE', '/api/cars/'.$product->id);
    	$delete->assertJson([ "Successful"]);
    }*/

    /** @test */
    public function updateCar(){
    	$response = $this->json('GET', '/api/cars');
    	$product = $response->getData()[0];

    	//$car = factory(\App\Car::class)->create();

    	$update = $this->json('PUT', '/api/cars/'.$product->id,['car_name' => "DaihatsuGo"]);
    	$update->assertJson(["Successful!"]);


    }
}
