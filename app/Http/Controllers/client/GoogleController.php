<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('google_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'username' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'password' => encrypt('123456789'),
                    'role' => 2,
                    'google_id' => $user->id
                ]);
                Auth::login($newUser);
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đăng nhập thất bại! Vui lòng thử lại');
        }
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('facebook_id', $user->id)->first();
            if ($finduser) {
                Auth::login($finduser);
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công!');
            } else {
                $newUser = User::updateOrCreate(['email' => $user->email], [
                    'username' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'password' => encrypt('123456789'),
                    'role' => 2,
                    'facebook_id' => $user->id
                ]);
                Auth::login($newUser);
                return redirect()->intended('/')->with('success', 'Đăng nhập thành công');
            }
        } catch (Exception $e) {
             return redirect()->back()->with('error', 'Đăng nhập thất bại! Vui lòng thử lại');
        }
    }
}
