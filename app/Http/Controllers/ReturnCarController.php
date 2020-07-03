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

        //$var = Car::findOrFail($request->car_id);
        //$varBook = Booked::findOrFail($request->book_id); 
        $var = Booked::findOrFail($request->book_id);
        $get = $var->vehicle_id;
        $carInfo = Car::findorFail($get);


        try{
            date_default_timezone_set('Asia/Jakarta');
            $getDate = date("Y-m-d H:i:s");

            /*if($request->date_return < $getDate){
                return response([
                    "please fill the right date",
                ]);
            }*/

           

            if($carInfo->taken == true && $request->book_id != NULL){

                $endDate = new \DateTime($request->date_return);
                $startDate = new \DateTime($var->book_date);
                //$testDate = new \DateTime("2019-10-05 10:15:20");
                
                $diff = $endDate->diff($endDate);
                $hours = $diff->h;
                $hours = $hours + ($diff->days*24);

                if($hours <1){
                    $hours = 1;
                }

                $totalPrice = $carInfo->price * $hours;
                $newData = [
                //'user_id' => $request->user_id,
                //'car_id' => $request->car_id,
                'book_id' => $request->book_id,
                'date_return' => $getDate,
                'duration' => $hours,
                'price' => $totalPrice,
                ];

                $fill = ReturnCar::create($newData);

                $carInfo->taken = false;
               
                //$varBook->duration = date_diff($endDate, $startDate)->format("%a");
                //$varBook->duration = date_diff($endDate, $startDate);

                //$varBook->returned = true;

                //$varBook->paid = true;
                //$varBook->total_price = $totalPrice;
               
                $carInfo->save();
                //$varBook->save();


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

        //$testvar = ReturnCar::findOrFail($id);
        //$bookinfo = $testvar->book_id;
        //$carinfo = Booked::findorFail($bookinfo);
        //$carid = $carinfo->car_id;
        //$findcar = 
        /*try{
            
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
        }*/

        /*try{
            $varc = Car::findOrFail($carid);
            return response([$varc]);

        }catch(\Exception $e){
            return response([
                    $e->getMessage()
            ]);
        }*/

       try{
            

            $var = ReturnCar::leftjoin('bookeds','bookeds.id', '=', 'return_cars.book_id')
            ->leftjoin('cars', 'cars.id', '=', 'bookeds.vehicle_id')
            ->leftjoin('users', 'users.id', '=', 'bookeds.user_id')
            ->select('users.name', 'cars.vehicle_name', 'return_cars.price', 'return_cars.duration', 'return_cars.date_return')
            ->where('users.id', $id)->get();

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

    public function showCarReturnHistory($id){
         try{
            

            $var = ReturnCar::leftjoin('bookeds','bookeds.id', '=', 'return_cars.book_id')
            ->leftjoin('cars', 'cars.id', '=', 'bookeds.vehicle_id')
            ->leftjoin('users', 'users.id', '=', 'bookeds.user_id')
            ->select('users.name', 'cars.vehicle_name', 'return_cars.price', 'return_cars.duration', 'return_cars.date_return')
            ->where('users.id', $id)
            ->where('cars.vehicle_category', '=', 'car')->get();

            return $var;
            
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }

    public function showMotorcycleReturnHistory($id){
         try{
            

            $var = ReturnCar::leftjoin('bookeds','bookeds.id', '=', 'return_cars.book_id')
            ->leftjoin('cars', 'cars.id', '=', 'bookeds.vehicle_id')
            ->leftjoin('users', 'users.id', '=', 'bookeds.user_id')
            ->select('users.name', 'cars.vehicle_name', 'return_cars.price', 'return_cars.duration', 'return_cars.date_return')
            ->where('users.id', $id)
            ->where('cars.vehicle_category', '=', 'motorcycle')->get();

            return $var;
            
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }
}
