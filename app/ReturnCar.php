<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnCar extends Model
{
   protected $fillable = [

    	'user_id', 'car_id', 'date_return'

	];


    public function users(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function cars(){
    	return $this->belongsTo('App\Car', 'car_id');
    }
}
