<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReturnCar;
use App\Car;
use App\Booked;

class ReturnCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ReturnCar::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $getDate = date("Y-m-d");

            if($request->date_return < $getDate){
                return response([
                    "please fill the right date",
                ]);
            }

            $var = Car::findOrFail($request->car_id);
            $varBook = Booked::findOrFail($request->book_id); 

            if($var->taken == true && $request->user_id != NULL && $request->car_id != NULL && $request->book_id != NULL && $request->date_return != NULL){

                $newData = [
                'user_id' => $request->user_id,
                'car_id' => $request->car_id,
                'book_id' => $request->book_id,
                'date_return' => $request->date_return,
                ];

                $fill = ReturnCar::create($newData);

                $var->taken = false;
                $var->save();

                $varBook->returned = true;
                $varBook->save();



                return response([
                    "Successful!",
                ]);
            }else{
                return response([
                    "Failed, you cannot return an unbooked car"
                ]);
            }

            
            
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        try{
            
            $var = ReturnCar::where('user_id',$id)->first();
           // $var = ReturnCar::where('')
            return response([
                'return' => $var
            ]);
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try{
            $var = ReturnCar::findOrFail($id);
            if(isset($var)){
                $var->delete();
                return response()->json([
                    "Successful"
                ]);
            }    
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
