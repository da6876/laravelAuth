<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AuthController extends Controller
{

    public function __construct(){
        $this->middleware("auth:sanctum",['except'=>["register","login"]]);
    }

    public function register (Request $request){
        try{
            $request->validate([
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:4|confirmed'
            ]);

            $user = User::create([
                'name' => ucwords($request->name),
                'email' => $request->email,
                'password' => bcsqrt($request->password),
            ]);

            $token = $user->createToken("token-name")->plainTextToken;

            return response()->json([
                "success" => true,
                "user" => $user,
                "token" => $token

            ]);
        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }

    public function logout(){

        try{
            Auth::user()->tokens()->delete();
            //$request-$user()->currentAccessToken()->delete();
            return response()->json([
                "success" => true,
                "message" => "Logged Out !"

            ]);
        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }


    public function login (Request $request){
        try{
            $stateData = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if(Auth::attempt($stateData)){
                return response()->json([
                    "success" => false,
                    "message" => "Login Failed !"
        
                ]);
            }

            $user=User::where("email",$request["email"])->firstOrFail();

            $token = $user->createToken("token-name")->plainTextToken;

            return response()->json([
                "success" => true,
                "user" => $user,
                "token" => $token

            ]);

        }catch (\Exception $e) {

            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);

        }
    }
}
