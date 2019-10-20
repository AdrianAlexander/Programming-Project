<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Booked;
use App\User;

class BookedTest extends TestCase
{

	use WithFaker;

    /** @test */
    public function getAllBooked(){
    	$response = $this->json('GET', '/api/books');
    	$response->assertStatus(200);
    	$response->assertJsonStructure(
                [
                    [
                            'id',
                            'user_id',
                            'car_id',
                            'total_price',
                            'book_date',
                            'returned',
                            'paid',
                            'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    /** @test */
    public function showBooked(){
    	$response = $this->json('GET', '/api/users');
    	$product = $response->getData()[16];

    	$showCar = $this->json('GET', '/api/books/'.$product->id);
    	$showCar->assertJsonStructure(
                [
                    [
                            'id',
                            'car_id',
                            'car_name',
                            'plate_number',
                            'image',
                            'price',
                            'returned',
                            'name',
                            'total_price',
                            'paid',
                    ]               
                ]
            );
    }

	/** @test */
    public function createBooked()
    {
    	//you can use this to create data manually
        $data = [
        	'user_id' => 18,
        	'car_id' => 5,
        	'book_date' => date("Y-m-d"),
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/books',$data);
       
        $response->assertJson(["Successful!"]);
    }

    /** @test */
    public function failBooked(){
    	$data = [
        	'user_id' => 18,
        	'car_id' => 13,
        	'book_date' => date("Y-m-d"),
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/books',$data);
       
        $response->assertJson(["Car has been booked, please choose another car"]);
    }

}
