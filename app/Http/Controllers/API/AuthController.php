<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login()
    {
        $credentials = [
            'email' => request('email'), 
            'password' => request('password')
        ];

        $status = 401;
        $error = ['error' => 'Unauthorised'];

        if (Auth::attempt($credentials)) {


            $data['token'] = Auth::user()->createToken('MyApp')->accessToken;
            $data['user'] = Auth::user();

            return response()->json(['message' => $data]);
        }
        return response()->json($error, $status);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $data['token'] = $user->createToken('MyApp')->accessToken;
        $data['user'] = $user;

        return response()->json(['message' => $data]);
    }

    public function getDetails()
    {
        return response()->json(['message' => Auth::user()]);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'You have been successfully logged out!']);
    }
}
