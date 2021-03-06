<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booked extends Model
{
    protected $fillable = [

    	'user_id', 'vehicle_id', 'book_date'

	];

	protected $casts = [
    	//'returned' => 'boolean',
        'paid' => 'boolean'
    ];

    public function users(){
    	return $this->belongsTo('App\User', 'user_id');
    }

    public function cars(){
    	return $this->belongsTo('App\Car', 'vehicle_id');
    }

    public function returnCars(){
    	return $this->hasOne('App\ReturnCar', 'book_id');
    }
}
