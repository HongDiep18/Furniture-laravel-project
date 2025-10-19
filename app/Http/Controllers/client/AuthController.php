<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPassword;
use App\Models\User;
use App\Models\UserResetToken;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Str;
class AuthController extends Controller
{
    public function pageLogin()
    {
        return view('client.pages.auth.login');
    }

    public function pageRegister()
    {
        return view('client.pages.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'phone_number' => 'required|numeric|digits:10',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ], [
            'username.required' => 'Tên không được bỏ trống.',
            'username.max' => 'Tên quá dài. Chọn tên ngắn hơn',
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone_number' => 'Số điên thoại không đúng định dạng.',
            'password.required' => 'Password không được bỏ trống.',
            'password.min' => 'Password phải từ 6 kí tự trở lên.',
            'confirm_password.same' => 'Mật khẩu không trùng khớp.',
        ]);

        try {
            $user = User::create([
                'username' => $validated['username'],
                'email' => $validated['email'],
                'phone_number' => $validated['phone_number'],
                'avatar' => 'https://ui-avatars.com/api/?name=' . $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 2
            ]);

            Auth::login($user);
            return redirect()->route('home')->with('success', 'Đăng ký tài khoản thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo đăng ký. Vui lòng thử lại!');
        }
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        $status = Auth::attempt([
            'email' => $email, 
            'password' => $password,
            'role' => 2
        ]);
        if ($status) {
            return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
        }
        
        return redirect()->back()->withInput()->with('error', 'Tài khoản không đúng. Vui lòng thử lại!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back()->with('success', 'Đã đăng xuất!');
    }

    public function forgot_password()
    {
        return view('client.pages.auth.forgot-password');
    }

    public function check_forgot_password(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:user,email',
        ], [
            'email.required' => 'Email không được bỏ trống.',
            'email.exists' => 'Không có tài khoản sử dụng email này.',
        ]);

        $user = User::where('email', $validated['email'])->first();
        $token = Str::random(40);

        $tokenData = [
            'email' => $validated['email'],
            'token' => $token
        ];

        if (UserResetToken::create($tokenData)) {
            Mail::to($validated['email'])->send(new ForgotPassword($user, $token));

            return redirect()->back()->with('success', 'Kiểm tra email để lấy lại mật khẩu!');
        }

        return redirect()->back()->with('error', 'Hành động không thành công. Vui lòng thử lại!');
    }

    public function reset_password($token) {
        $tokenData = UserResetToken::where('token', $token)->firstOrFail();

        return view('client.pages.auth.reset-password', compact('token'));
    }

    public function check_reset_password(Request $request) {
        $validated = $request->validate([
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|same:password'
        ], [
            'password.required' => 'Password không được bỏ trống.',
            'password.min' => 'Password phải từ 6 kí tự trở lên.',
            'confirm_password.same' => 'Mật khẩu không trùng khớp.',
        ]);
        $tokenData = UserResetToken::where('token', $request->token)->firstOrFail();

        $user = $tokenData->user;

        $user->password = Hash::make($validated['password']);
        $user->save();

        UserResetToken::where('email', $user->email)->delete();

        return redirect()->route('client.login')->with('success', 'Mật khẩu đã được đặt lại thành công!');
    }
}
