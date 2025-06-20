<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $ttlInSeconds = Auth::factory()->getTTL() * 60;
        $expiresAtTimestamp = time() + $ttlInSeconds;


        if (!$token = Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Email hoặc mật khẩu không đúng.'
            ], 401);
        }
        return response()->json([
            'status' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttlInSeconds,
            'expires_at' => $expiresAtTimestamp, // cái này chính là 1750392325 dạng timestamp
        ], 200);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed', // yêu cầu password_confirmation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user); // tự động login và trả token luôn

        return response()->json([
            'status' => true,
            'message' => 'Đăng ký thành công!',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user
        ], 201);
    }

    public function me()
    {
        return response()->json([
            'status' => true,
            'user' => auth()->user()
        ]);
    }
    public function forgotPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);

            $token = Str::random(60);
            $hashedToken = Hash::make($token);

            // Lưu vào bảng password_resets
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $hashedToken, 'created_at' => Carbon::now()]
            );

            // Gửi email
            $user = User::where('email', $request->email)->first();
            $user->notify(new ResetPasswordNotification($token)); // gửi token chưa mã hóa

            return response()->json([
                'status' => true,
                'message' => 'Email khôi phục đã được gửi!',
                'token' => $token // để test
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$reset) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy yêu cầu đặt lại mật khẩu.'
            ], 400);
        }

        // Log để kiểm tra nếu cần
        \Log::info('Token gửi về:', [$request->token]);
        \Log::info('Token trong DB:', [$reset->token]);

        // So sánh token
        if (!Hash::check($request->token, $reset->token)) {
            return response()->json([
                'status' => false,
                'message' => 'Token không hợp lệ hoặc đã hết hạn.'
            ], 400);
        }

        // Cập nhật mật khẩu
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Mật khẩu đã được đặt lại thành công!'
        ]);
    }

}