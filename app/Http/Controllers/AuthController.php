<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use JWTAuth;
use Validator;
use Hash;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request){
        
		$credentials = $request->only('name', 'email', 'password');

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required'
        ];

        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

        $name = $request->name;
        $email = $request->email;
        $password = $request->password;
      
        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password)]);
        
        return response()->json(['success'=> true, 'message'=> 'Thanks for signing up!']);
	}

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => 'error', 
                'message' => $validator->messages()
            ]);
        }
        try {
            // Attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'We can`t find an account with this credentials.'
                ], 401);
            }
        } catch (JWTException $e) {
            // Something went wrong with JWT Auth.
            return response()->json([
                'status' => 'error', 
                'message' => 'Failed to login, please try again.'
            ], 500);
        }
        // All good so return the token
        $var = User::select('id', 'name')->where('email', $request->email)->first();
        
        

        return response()->json([
            'status' => 'success', 
            'data'=> [
                'token' => $token,
                'user' => $var
               
            ]
        ]);




    }

    /**
     * Logout
     * Invalidate the token. User have to relogin to get a new token.
     * @param Request $request 'header'
     */
    public function logout(Request $request) 
    {
       
        try {
            JWTAuth::invalidate();
            return response()->json(['success' => true, 'message'=> "You have successfully logged out."]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['success' => false, 'error' => 'Failed to logout, please try again.'], 500);
        }
    
    }

    public function refreshToken(){
        $token = JWTAuth::getToken();
        if(!$token){
            throw new BadRequestHtttpException('Token not provided');
        }
        try{
            $token = JWTAuth::refresh($token);
        }catch(TokenInvalidException $e){
            throw new AccessDeniedHttpException('The token is invalid');
        }
        return response()->json([
            'status' => 'success', 
            'data'=> [
                'token' => $token
               
            ]
        ]);
	}
}
