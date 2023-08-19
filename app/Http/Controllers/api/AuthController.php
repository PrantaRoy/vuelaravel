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

        Auth::login($user);

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

    public function updateProfile(Request $req){
        $input = $req->all();
        $validate = Validator::make($input,[
            'email' => 'required|email',
            'phone' => 'required',
            'name' => 'required',
        ]);

        if($validate->fails()){
            $response = [
                'success' => false,
                'data' => 'Validation Error',
                'message' => $validate->errors()
            ];

            return response()->json($response,400);
        }

        $user = Auth::user();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->phone = $req->phone;
        $user->update();
        $response = [
            'success' => true,
            'data' =>  $user,
            'message' => 'Update Successfull'
        ];
        return response()->json($response,200);
    }

    public function updatePassword(Request $req){
        $input = $req->all();
        $validate = Validator::make($input,[
            'password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validate->fails()){
            $response = [
                'success' => false,
                'message' => $validate->errors()
            ];
            return response()->json($response,400);
        }

        $user = Auth::user();
        $user->password =  bcrypt($input['new_password']) ;
        $user->save();
        $response = [
            'success' => true,
            'data' =>  $user,
            'message' => 'Password Update Successfull'
        ];
        return response()->json($response,200);
    }

    public function logout(){
       Auth::logout();
        $response = [
            'success' => true,
            'data' =>  'Logout',
            'message' => 'Logout Successfull'
        ];
        return response()->json($response,200);
    }
}
