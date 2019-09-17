<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booked;
use App\Car;

class BookedController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Booked::all();
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

            if($request->book_date < $getDate){
                return response([
                    "please fill the right date",
                ]);
            }

            $var = Car::findOrFail($request->car_id);

            if($var->taken == true){
                return response([
                    "Car has been booked, please choose another car",
                ]);
            }

            if($var->taken == false && $request->user_id != NULL && $request->car_id != NULL && $request->book_date != NULL && $request->duration != NULL){

                $newData = [
                'user_id' => $request->user_id,
                'car_id' => $request->car_id,
                'book_date' => $request->book_date,
                'duration' => $request->duration,
                ];

                $fill = Booked::create($newData);

                $var->taken = true;
                $var->save();



                return response([
                    "Successful!",
                ]);
            }else{
                return response([
                    "Failed, please don't leave an empty field"
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
            
            //$var = Booked::select('cars.car_name', 'cars.id')->leftjoin('cars','cars.id','=','books.car_id')->where('id', $id);
            $var = Booked::where('bookeds.id', $id)
            ->leftjoin('cars', 'bookeds.car_id', '=', 'cars.id')
            ->leftjoin('users', 'bookeds.user_id', '=', 'users.id')
            ->select('bookeds.id', 'users.name', 'cars.car_name', 'cars.car_type', 'bookeds.book_date')->first();
            //$var = Booked::leftjoin('cars','cars.id','=', 'books.car_id')->select('cars.*')->where('books.id', $id)->first();
            return response([
                'booked' => $var
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
            $var = Booked::findOrFail($id);
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
