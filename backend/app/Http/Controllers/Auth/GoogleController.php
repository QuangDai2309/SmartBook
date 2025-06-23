<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth; // Nếu dùng JWT
use Illuminate\Support\Str;


class GoogleController extends Controller
{
    public function loginWithGoogle(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $google_token = $request->token;

        $client = new \Google_Client(['client_id' => config('services.google.client_id')]);
        $payload = $client->verifyIdToken($google_token);

        if (!$payload) {
            return response()->json(['message' => 'Token Google không hợp lệ'], 401);
        }

        // Xác định user qua email
        $user = User::firstOrCreate(
            ['email' => $payload['email']],
            [
                'name' => $payload['name'] ?? '',
                'password' => bcrypt(Str::random(12)), // tạo tạm
                'role' => 'user' // mặc định user thường
            ]
        );

        // Đăng nhập và tạo token
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'token' => $token,
            'user' => $user
        ]);
    }
}
