<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$allCar = Car::select('car_name', 'car_type', 'plate_number', 'fuel', 'taken')->get();
        $allCar = Car::all();
        return $allCar;
     
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
            //prevents creating a record with nothing in it
            if($request->car_name != NULL && $request->car_type != NULL && $request->plate_number != NULL && $request->fuel != NULL && $request->description != NULL && $request->price != NULL && $request->image != NULL){

                $newData = [
                'car_name' => $request->car_name,
                'car_type' => $request->car_type,
                'plate_number' => $request->plate_number,
                'fuel' => $request->fuel,
                'description' => $request->description,
                'price' => $request->price,
                'image' => $request->image,
                ];

                $fill = Car::create($newData);


                return response([
                    "Successful!",
                ]);
            }else{
                return response([
                    "Failed",
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
            $var = Car::findOrFail($id);

            return response([$var]);

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

        try{
            if($request->car_name != NULL || $request->car_type != NULL || $request->plate_number != NULL || $request->fuel != NULL || $request->description != NULL || $request->price != NULL || $request->image != NULL){

               $var = Car::findOrFail($id);

               if($request->car_name == NULL){
                    $request->car_name = $var->car_name;
               }

               if($request->car_type == NULL){
                    $request->car_type = $var->car_type;
               }

               if($request->plate_number == NULL){
                    $request->plate_number = $var->plate_number;
               }

               if($request->fuel == NULL){
                    $request->fuel = $var->fuel;
               }

               if($request->description == NULL){
                    $request->description = $var->description;
               }

               if($request->price == NULL){
                    $request->price = $var->price;
               }

               if($request->image == NULL){
                    $request->image = $var->image;
               }

               $var->update([
                    'car_name' => $request->car_name,
                    'car_type' => $request->car_type,
                    'plate_number' => $request->plate_number,
                    'fuel' => $request->fuel,
                    'description' =>$request->description,
                    'price' => $request->price,
                    'image' => $request->image
               ]);


                return response([
                    "Successful!",
                ]);

            }else{
                return response([
                    "Failed",
                ]);
            }

        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
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
            $var = Car::findOrFail($id);
            if(isset($var)){
                $var -> delete();

                return response([
                    "Successful"
                ]);
            }
        }catch(\Exception $e){
            return response([
                $e->getMessage()
            ]);
        }
    }
}
