<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::all()->where('email','kentang@gmail.com')->select('id','name')->get();
        //return User::select('id', 'name')->where('email','kentang@gmail.com')->get();
        return User::all();
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
            $var = User::findOrFail($id);
            //$var = User::select('id', 'password')->where('id', $id)->first();

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
            if($request->name != NULL || $request->password !=NULL){

                $var = User::findOrFail($id);

                if($request->name == NULL){
                    $request->name = $var->name;
                }

                if($request->password == NULL){
                    $request->password == $var->password;
                }


                $var->update([
                        'name' => $request->name,
                        'password' => Hash::make($request->password),
                     ]);

                return response([
                    "Successful"
                ]);

            }else{
               return response([
                    "No Changes Were Made"
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
            $var = User::findOrFail($id);
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
