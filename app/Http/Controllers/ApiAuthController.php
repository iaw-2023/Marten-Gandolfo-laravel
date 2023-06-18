<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        // TODO
        // Validate the login request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $client = Client::where('email', $credentials['email'])->first();
            $token = $client->createToken('client-token')->plainTextToken;
            return response()->json([
                'token' => $token
            ], 200);
        } else {
            // Authentication failed
            return response()->json([
                'message' => 'Authentication error'
            ], 401);
        }
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged Out'
        ], 200);
    }
}
