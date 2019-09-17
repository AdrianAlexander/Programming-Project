<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function open(){
    	return "open sesame";
    }

    public function closed(){
    	return "you cannot see this unless you're authorized";
    }
}
