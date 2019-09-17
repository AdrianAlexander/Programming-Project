<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booked extends Model
{
    protected $fillable = [

    	'user_id', 'car_id', 'book_date', 'duration'

	];

    public function users(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function cars(){
    	return $this->belongsTo('App\Car', 'car_id');
    }
}
