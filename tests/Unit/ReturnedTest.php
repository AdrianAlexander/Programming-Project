<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ReturnCar;

class ReturnedTest extends TestCase
{
    /** @test */
   public function getAllReturn(){
    	$response = $this->json('GET', '/api/returncars');
    	$response->assertStatus(200);
    	$response->assertJsonStructure(
                [
                    [
                            'id',
                            'user_id',
                            'car_id',
                            'book_id',
                            'duration',
                            'price',
                            'date_return',
							'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    /** @test */
    public function returnCar(){
        //you can use this to create data manually
        $data = [
            'user_id' => 18,
            'car_id' => 5,
            'book_id' => 11,
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/returncars',$data);
       
        $response->assertJson(["Successful!"]);
    }


    /** @test */
    public function showReturn(){
        $response = $this->json('GET', '/api/users');
        $product = $response->getData()[16];

        $showCar = $this->json('GET', '/api/returncars/'.$product->id);
        $showCar->assertJsonStructure(
                [
                    [
                            'name',
                            'car_name',
                            'price',
                            'duration',
                            
                    ]               
                ]
            );
    }



   


}
