<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name'=>'required|max:191',
            'email'=>'required|email|max:191|unique:users',
            'password'=>'required|min:8'
        ]);
        if($validator->fails()){
             return response()->json([
                'validation_errors'=>$validator->messages(),
                'status'=>400,
             ]);
        }else{
            $user=User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'role_as'=> 'user',
            ]);
          $token = $user->createToken($user->email.'_Token')->plainTextToken;
           return response()->json([
                'status'=>200,
                'username'=>$user->name,
                'token'=>$token,
                'message'=>'Registered Successfully',
             ]);
        }

    }
 public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:191',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 400, 'validation_errors' => $validator->messages()]);
        }

        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['message' => 'Unauthorized', 'status' => 401]);
            }

            $user = auth()->user();

            $role = $user->role_as === 'admin' ? 'admin' : 'user';

            return $this->respondWithToken($token, $user, $role);
        } catch (\JWTException $e) {
            return response()->json(['message' => 'Could not create token', 'status' => 500]);
        }
    }



 public function logout(Request $request)
{
    try {
        Auth::logout();
        Session::flush();
        return response()->json([
            'status' => 200,
            'message' => 'You have been successfully logged out!',
        ]);
    } catch (\Exception $exception) {
        return response()->json([
            'status' => 500,
            'message' => 'An error occurred during logout.',
        ]);
    }
}





 public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
 protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user'=>auth()->user(),
            'role'=>auth()->user()->role_as,
            'status'=>200,
            'message'=>'Successfully Logged In!'
        ]);
    }

    }