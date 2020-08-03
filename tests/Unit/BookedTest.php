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
                            'vehicle_id',
                            'book_date',
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
    	$product = $response->getData()[0];

    	$showCar = $this->json('GET', '/api/books/'.$product->id);
    	$showCar->assertJsonStructure(
                [
                    [
                            'vehicle_name',
                            'vehicle_category',
                            'description',
                            'plate_number',
                            'name',
                            'paid',
                            'book_date',
                    ]               
                ]
            );
        $showCar->assertStatus(200);
    }

	/** @test */
    public function createBooked()
    {
    	//you can use this to create data manually
        $data = [
        	'user_id' => 1,
        	'vehicle_id' => 2,
        	//'book_date' => date("Y-m-d"),
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/books',$data);
       
        $response->assertJson(["Successful!"]);
        $response->assertStatus(200);
    }

    /** @test */
    public function failBooked(){
    	$data = [
        	'user_id' => 3,
        	'vehicle_id' => 4,
        	//'book_date' => date("Y-m-d"),
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/books',$data);
       
        $response->assertJson(["Car has been booked, please choose another car"]);
        $response->assertStatus(200);
    }

}
