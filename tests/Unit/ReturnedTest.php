<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\ReturnCar;
use App\Booked;

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
        $bookCount = Booked::count();
        $data = [
            'book_id' => $bookCount,
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/returncars',$data);
       
        $response->assertJson(["Successful!"]);
        $response->assertStatus(200);
    }


    /** @test */
    public function showReturn(){
        $response = $this->json('GET', '/api/users');
        $product = $response->getData()[0];

        $showCar = $this->json('GET', '/api/returncars/'.$product->id);
        $showCar->assertJsonStructure(
                [
                    [
                            'name',
                            'vehicle_name',
                            'price',
                            'duration',
                            'date_return',
                            
                    ]               
                ]
            );
        $showCar->assertStatus(200);
    }



   


}
