<?php

namespace App\Http\Controllers;

use App\Mail\ForgetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!auth()->attempt($credentials)) {
            return response()->json([
                'message' => 'Akun anda tidak terdaftar'
            ], 401);
        }
        $key = env('APP_KEY', base64_encode('secret'));
        $payload = [
            'id' => auth()->user()->id,
            'exp' => time() + 60 * 60,
        ];
        $token = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');
        return response()->json([
            'token' => $token
        ]);
    }
    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = bcrypt(request()->password);
        $user->save();

        return response()->json($user, 201);
    }
    public function sendForgetPasswordEmail()
    {
        Mail::to('to@example.com')->send(new ForgetPasswordMail(auth()->user()));
        return response()->json([
            'message' => 'Email reset password telah dikirim'
        ]);
    }
}
