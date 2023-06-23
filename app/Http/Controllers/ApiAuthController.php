<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Mail\ResetClientPassword;
use Illuminate\Support\Facades\Mail;

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

    public function register(Request $request){
        $credentials = $request->only('email', 'password');
        
        $validator = $this->getRegisterApiValidator($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        if(Client::where('email', $credentials['email'])->first()){
            return response()->json([
                'message' => 'User already exists'
            ], 400);
        }
        
        $client = new Client();
        $client->email = $credentials['email'];
        $client->password = bcrypt($credentials['password']);
        $client->save();
        
        $token = $client->createToken('client-token')->plainTextToken;
        return response()->json([
            'message' => 'User registered',
            'token' => $token
        ], 200);
    }

    private function getRegisterApiValidator($request){
        return Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:4',
        ]);
    }

    public function requestPasswordReset(Request $request){
        if (Validator::make($request->all(), ['email' => 'required|email'])->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $email = $request->input('email');

        $client = Client::where('email', $email)->first();
        if($client){
            $token = Str::random(32);
            while(Client::where('reset_token', $token)->exists()){
                $token = Str::random(32);
            }

            $client->reset_token = $token;
            $client->save();
            
            Mail::to($client->email)->send(new ResetClientPassword($token));
        }

        // TODO enviar token por email
        return response()->json([
            'message' => 'ok'
        ], 200);
    }

    public function resetPassword(Request $request){


        if (Validator::make($request->all(), ['password' => 'required|min:4'])->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }
        if(!preg_match('/^[a-zA-Z0-9]{32}$/', $request->input('token')))
            return response()->json(['message' => 'Invalid token format'], 400);

        $password = $request->input('password');
        $token = $request->input('token');

        $client = Client::where('reset_token', $token)->first();

        if($client){
            $client->reset_token = null;
            $client->password = bcrypt($password);
            $client->save();
        
            return response()->json([
                'message' => 'Password recovered',
                'token' => $client->createToken('client-token')->plainTextToken
            ], 200);
        }else{
            return response()->json([
                'message' => 'Invalid token'
            ], 400);
        }
    }
}
