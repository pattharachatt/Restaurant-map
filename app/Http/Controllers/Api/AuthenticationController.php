<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AuthenticationController extends Controller
{
    
    /**
     * Login API
     */
    public function login(Request $request) 
    {
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            return response(['error_message' => 'Incorrect Details. 
            Please try again']);
        }

        $user = User::where('email', $data['email'])->first();
        $user->tokens()->delete();
        $token = $user->createToken('postman');

        return response()->json(['token' => $token->plainTextToken]);
    }
    
    /**
     * Register API
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        $token = $user->createToken('postman');
        return response([ 'user' => $user, 'token' => $token->plainTextToken]);
    }
}
