<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
    	'car_name', 'car_type', 'plate_number', 'fuel', 'description', 'price', 'image', 'taken'
    ];

    protected $casts = [
    	'taken' => 'boolean'
    ];

    public function bookeds(){
    	return $this->hasOne('App\Booked', 'car_id');
    }

    public function returnCars(){
    	return $this->hasOne('App\ReturnCar', 'car_id');
    }

}
