<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class loginController extends Controller
{
    public function login(Request $request){
        $data = $request -> validate([
            'email' => ['required', 'email', 'exists:usuario'],
            'password' => ['required', 'min:6'],
        ]);
        
        //$user = User::create($data);
        $user = User::where('email', $data['email'])->first();
        
        if(!$user || !Hash::check($data['password'],$user->password)){
            return response([
                'message' => 'Credenciales incorrectas'
            ],401);
        }

        
        $token = $user-> createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
}
