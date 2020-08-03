<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Staff;

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
            if($request->staff_id != NULL && $request->vehicle_name != NULL && $request->vehicle_category != NULL && $request->vehicle_type != NULL && $request->plate_number != NULL && $request->fuel != NULL && $request->description != NULL && $request->price != NULL && $request->longitude !=NULL && $request->latitude !=NULL && $request->image != NULL){

                $newData = [
                'staff_id' => $request->staff_id,
                'vehicle_name' => $request->vehicle_name,
                'vehicle_category' => $request->vehicle_category,
                'vehicle_type' => $request->vehicle_type,
                'plate_number' => $request->plate_number,
                'fuel' => $request->fuel,
                'description' => $request->description,
                'price' => $request->price,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
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
            if($request->staff_id != NULL || $request->vehicle_name != NULL || $request->vehicle_category != NULL || $request->vehicle_type != NULL || $request->plate_number != NULL || $request->fuel != NULL || $request->description != NULL || $request->price != NULL || $request->longitude != NULL || $request->latitude !=NULL || $request->image != NULL){

               $var = Car::findOrFail($id);

               if($request->vehicle_name == NULL){
                    $request->vehicle_name = $var->vehicle_name;
               }

               if($request->vehicle_category == NULL){
                    $request->vehicle_category = $var->vehicle_category;
               }

               if($request->vehicle_type == NULL){
                    $request->vehicle_type = $var->vehicle_type;
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

               if($request->longitude == NULL){
                    $request->longitude = $var->longitude;
               }

               if($request->latitude == NULL){
                    $request->latitude = $var->latitude;
               }

               if($request->image == NULL){
                    $request->image = $var->image;
               }

               $var->update([
                    'staff_id' => $request->staff_id,
                    'vehicle_name' => $request->vehicle_name,
                    'vehicle_category' => $request->vehicle_category,
                    'vehicle_type' => $request->vehicle_type,
                    'plate_number' => $request->plate_number,
                    'fuel' => $request->fuel,
                    'description' =>$request->description,
                    'price' => $request->price,
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
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

    public function showCar(){
        $var = Car::where('vehicle_category', '=', 'car')->get();
        return $var;
    }

    public function showMotorcycle(){
        $var = Car::where('vehicle_category', '=', 'motorcycle')->get();
        return $var;
    }
}
