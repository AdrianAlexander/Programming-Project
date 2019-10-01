<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use Illuminate\Support\Str;
use Hash;


class UserTest extends TestCase
{
	use WithFaker;

     /** @test */
    public function createUser()
    {
        //you can use this to create data manually
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => "secret",
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/register',$data);
       
        $response->assertJson(['success'=> true, 'message'=> 'Thanks for signing up!']);
    }

    /** @test */
    public function getAllUser(){
    	$response = $this->json('GET', '/api/users');
    	$response->assertStatus(200);
    	$response->assertJsonStructure(
                [
                    [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    /** @test */
    public function showUser(){
    	$response = $this->json('GET', '/api/users');
    	$product = $response->getData()[0];

    	$showCar = $this->json('GET', '/api/users/'.$product->id);
    	$showCar->assertJsonStructure(
                [
                    [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    

    /** @test */
    /*public function destroyUser(){
    	$response = $this->json('GET', '/api/users');
    	$product = $response->getData()[0];



    	//$car = factory(\App\Car::class)->create();

    	$delete = $this->json('DELETE', '/api/users/'.$product->id);
    	$delete->assertJson([ "Successful"]);
    }*/

    /** @test */
    public function updateUser(){
    	$response = $this->json('GET', '/api/users');
    	$product = $response->getData()[0];

    	//$car = factory(\App\Car::class)->create();

    	$update = $this->json('PUT', '/api/users/'.$product->id,['name' => $this->faker->name, 'password' => Hash::make("secret")]);
    	$update->assertJson(["Successful"]);

    }


}
