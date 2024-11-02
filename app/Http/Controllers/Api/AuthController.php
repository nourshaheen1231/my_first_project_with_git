<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
class AuthController extends Controller
{
      // User registration
      public function register(Request $request)
      {
          $validator = Validator::make($request->all(), [
              'name' => 'required|string|max:255',
              'email' => 'required|string|email|max:255|unique:users',
              'password' => 'required|string|min:6',
          ]);
  
          if($validator->fails()){
              return response()->json($validator->errors()->toJson(), 400);
          }
  
          $user = User::create($request->all());
  
          //$token = JWTAuth::fromUser($user);
  
          return response()->json(['message'=>'User registerd successfully','user'=>$user], 201);
      }
         // User login
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = Auth::attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => Auth::user()
        ]);
    }
    public function logout()
    {
       Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }
    
    public function userProfile(){
        return response()->json(Auth::user());
    }
}
