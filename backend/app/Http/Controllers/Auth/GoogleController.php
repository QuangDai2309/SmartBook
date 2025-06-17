<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        // Dùng stateless để không cần session
        return Socialite::driver('google')->stateless()->redirect();
    }

    // public function handleGoogleCallback()
    // {
    //     try {
    //         // Lấy thông tin user từ Google
    //         $googleUser = Socialite::driver('google')->stateless()->user();

    //         // Tìm hoặc tạo mới user trong hệ thống
    //         $user = User::firstOrCreate(
    //             ['email' => $googleUser->getEmail()],
    //             [
    //                 'name' => $googleUser->getName(),
    //                 'google_id' => $googleUser->getId(),
    //                 'password' => bcrypt(uniqid()), // mật khẩu ngẫu nhiên nếu user mới
    //             ]
    //         );

    //         // Đăng nhập user và tạo JWT token
    //         $token = Auth::login($user);

    //         // Trả về token cho frontend
    //         return response()->json([
    //             'status' => true,
    //             'access_token' => $token,
    //             'token_type' => 'bearer',
    //             'expires_in' => Auth::factory()->getTTL() * 60,
    //             'user' => $user,
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Google login failed: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(uniqid()),
            ]
        );

        $token = Auth::login($user);

        // Redirect đến trang trung gian (để xử lý token phía client)
        return redirect()->to('/api/google-redirect?access_token=' . $token);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Google login failed: ' . $e->getMessage()
        ], 500);
    }
}

}
