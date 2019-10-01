<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ReturnCar;
use App\Car;
use App\Booked;
use App\User;

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

        $var = Car::findOrFail($request->car_id);
        $varBook = Booked::findOrFail($request->book_id); 

        try{
            date_default_timezone_set('Australia/Melbourne');
            $getDate = date("Y-m-d H:i:s");

            /*if($request->date_return < $getDate){
                return response([
                    "please fill the right date",
                ]);
            }*/

           

            if($var->taken == true && $request->user_id != NULL && $request->car_id != NULL && $request->book_id != NULL){

                $endDate = new \DateTime($request->date_return);
                $startDate = new \DateTime($varBook->book_date);
                //$testDate = new \DateTime("2019-10-05 10:15:20");
                
                $diff = $endDate->diff($endDate);
                $hours = $diff->h;
                $hours = $hours + ($diff->days*24);

                if($hours <1){
                    $hours = 1;
                }

                $totalPrice = $var->price * $hours;
                $newData = [
                'user_id' => $request->user_id,
                'car_id' => $request->car_id,
                'book_id' => $request->book_id,
                'date_return' => $getDate,
                'duration' => $hours,
                'price' => $totalPrice,
                ];

                $fill = ReturnCar::create($newData);

                $var->taken = false;
               
                //$varBook->duration = date_diff($endDate, $startDate)->format("%a");
                //$varBook->duration = date_diff($endDate, $startDate);
                $varBook->returned = true;
                //$varBook->paid = true;
                $varBook->total_price = $totalPrice;
               
                $var->save();
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
            
            $var = ReturnCar::where('user_id',$id)
            ->leftjoin('users','return_cars.user_id', '=', 'users.id')
            ->leftjoin('cars', 'return_cars.car_id', '=', 'cars.id')
            ->select('users.name', 'cars.car_name', 'return_cars.price', 'return_cars.duration')->get();
           // $var = ReturnCar::where('')
            return $var;
            
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
