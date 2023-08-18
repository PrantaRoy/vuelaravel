<?php

namespace App\Http\Controllers\api;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $req){
        $input = $req->all();
        $validate = Validator::make($input,[
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if($validate->fails()){
            $response = [
                'success' => false,
                'message' => $validate->errors()
            ];

            return response()->json($response,400);
        }

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('App')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User Registered Successfull'
        ];

        return response()->json($response,200);

    }


    public function login(Request $req){
        $input = $req->all();
        $validate = Validator::make($input,[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validate->fails()){
            $response = [
                'success' => false,
                'data' => 'Validation Error',
                'message' => $validate->errors()
            ];

            return response()->json($response,400);
        }

        if(Auth::attempt(['email' => $req->email, 'password' => $req->password])){
            $user = Auth::user();

            $success['token'] = $user->createToken('App')->plainTextToken;
            $success['name'] = $user->name;
            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'Login Successfull'
            ];
            return response()->json($response,200);
        }else{
            $response = [
                'success' => false,
                'data' => null,
                'message' => 'Login Unauthorised'
            ];
            return response()->json($response);
        }
    }
}
