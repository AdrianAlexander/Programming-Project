<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Staff;
use Illuminate\Support\Str;
use Hash;
use JWTAuth;

class StaffTest extends TestCase
{
    use WithFaker;

     /** @test */
    public function createStaff()
    {
        //you can use this to create data manually
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => "secret",
        ];

        //use this to create new data using faker
        //$user = factory(\App\User::class)->create(); 
        $response = $this->json('POST', '/api/staffregister',$data);
       
        $response->assertJson(['success'=> true, 'message'=> 'Thanks for signing up!']);
        $response->assertStatus(200);
        $response->assertJsonStructure(
                [
                    
                        'success',
                        'message'
                         
                ]
            );
                                    
    }

    /** @test */
    public function login(){
        $data = [
            'email' => "kentangg@gmail.com",
            'password' => "kentangg",
        ];

        $response = $this->json('POST', '/api/stafflogin', $data);
        $response->assertStatus(200);
        $response->assertJsonStructure(
                [
                    'status',
                    'data' =>
                    [
                        'token',
                        'user' =>
                        [
                            'id',
                            'name'
                        ]

                    ]
                ]
        );
    }

    /** @test */
    public function logout(){
    	$staff = Staff::findorFail(1);
        $token = JWTAuth::fromUser($staff);
        $data = [
            'token' => $token,
        ];

        $response = $this->json('POST', '/api/staff/stafflogout', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure(
                [
                    'success',
                    'message'
                ]
        );

        $response->assertJson(['success'=> true, 'message'=> 'You have successfully logged out.']);
    }

    

    

    /** @test */
    /*public function destroyUser(){
    	$response = $this->json('GET', '/api/users');
    	$product = $response->getData()[0];



    	//$car = factory(\App\Car::class)->create();

    	$delete = $this->json('DELETE', '/api/users/'.$product->id);
    	$delete->assertJson([ "Successful"]);
    }*/

    
}
