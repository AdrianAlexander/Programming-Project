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
                            'date_return',
							'created_at',
                            'updated_at'
                    ]               
                ]
            );
    }

    /** @test */
    public function showReturn(){
    	$response = $this->json('GET', '/api/users');
    	$product = $response->getData()[7];

    	$showCar = $this->json('GET', '/api/returncars/'.$product->id);
    	$showCar->assertJsonStructure(
                [
                    [
                            'id',
                            'user_id',
                            'car_id',
                            'book_id',
                            'date_return',
                            'created_at',
                            'updated_at'
                            
                    ]               
                ]
            );
    }
}
