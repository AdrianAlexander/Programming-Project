<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
    	'staff_id', 'vehicle_name', 'vehicle_category', 'vehicle_type', 'plate_number', 'fuel', 'description', 'price', 'longitude', 'latitude', 'image', 'taken'
    ];

    protected $casts = [
    	'taken' => 'boolean'
    ];

    public function bookeds(){
    	return $this->hasOne('App\Booked', 'vehicle_id');
    }

    /*public function returnCars(){
    	return $this->hasOne('App\ReturnCar', 'car_id');
    }*/
    public function staff(){
        return $this->belongsTo('App\Staff', 'staff_id');
    }

}
