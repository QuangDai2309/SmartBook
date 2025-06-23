<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Đăng ký
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // hoặc 'admin' nếu đăng ký quản trị
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'Đăng ký thành công',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Đăng nhập
       public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    \Log::info('Dữ liệu gửi lên: ', $credentials);

    if (!$token = JWTAuth::attempt($credentials)) {
        \Log::error('Login thất bại');
        return response()->json(['message' => 'Email hoặc mật khẩu không đúng'], 401);
    }

    $user = auth('api')->user();
    \Log::info('Login thành công: ', [$user]);

    return response()->json([
        'message' => 'Đăng nhập thành công',
        'user' => $user,
        'token' => $token,
    ]);
}



    // Lấy thông tin user
    
        public function me(Request $request)
        {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json($user);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        }

        public function logout(Request $request)
{
    try {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Đã đăng xuất']);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Lỗi khi đăng xuất'], 500);
    }
}

}


