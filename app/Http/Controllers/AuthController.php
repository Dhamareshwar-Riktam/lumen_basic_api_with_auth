<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class AuthController extends Controller {
    public function register(Request $request) {
        $validate = Validator::make($request->json()->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 400);
        }

       $email = $request->json()->get('email');
       $password = $request->json()->get('password');

        $checkEmail = DB::table('users')->where('email', $email)->first();

        if ($checkEmail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email already exists',
            ], 400);
        }

        $register = DB::table('users')->insert([
            'email' => $email,
            'password' => $password,
            'name' => $request->json()->get('name'),
            'role' => $request->json()->get('role'),
        ]);

        if ($register) {
            return response()->json([
                'status' => 'success',
                'message' => 'Register successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Register failed',
            ], 400);
        }
    }

    public function login(Request $request) {
        $validate = Validator::make($request->json()->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validate->errors(),
            ], 400);
        }

        $email = $request->json()->get('email');
        $password = $request->json()->get('password');

        $checkEmail = DB::table('users')->where('email', $email)->first();

        if (!$checkEmail) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email not found',
            ], 400);
        }

        $checkPassword = DB::table('users')->where('email', $email)->where('password', $password)->first();

        if (!$checkPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password is incorrect',
            ], 400);
        }

        $payload = [
            'email' => $email,
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json([
            'status' => 'success',
            'message' => 'Login successfully',
            'data' => [
                'token' => $jwt,
            ],
        ], 200);
    }

    public function me(Request $request) {
        error_log("000 " . $request->user()->email);
        return response()->json([
            'status' => 'success',
            'message' => 'Get user data successfully',
            'data' => [
                'email' => $request->user()->email,
                'name' => $request->user()->name,
                'role' => $request->user()->role,
            ],
        ], 200);
    }
}

