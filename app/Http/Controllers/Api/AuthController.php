<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\contributors;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:contributors',
            'mobile_no' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:contributors',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $contributor = contributors::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
$token = $contributor->createToken('auth_token')->plainTextToken;
           return response()->json([
            'status' => true,
            'message' => 'User Registered Successfully',
            'token' => $token,
            'contributor' => $contributor
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]); 

        $contributor = contributors::where('email', $request->email)->first();
        
        if (!$contributor || !Hash::check($request->password, $contributor->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password',
            ], 401);
        }

        $token = $contributor->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'contributor' => $contributor
        ], 200);

    }
}
