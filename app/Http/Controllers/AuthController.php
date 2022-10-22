<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $data = Socialite::driver($provider)->user();
        $checkExit = true;

        $user = User::query()
            ->where('email', $data->getEmail())
            ->first();

        if (is_null($user)) {
            $user = new User();
            $user->email = $data->getEmail();
            $user->name = $data->getName();
            $user->avatar = $data->getAvatar();
            $user->save();
            $checkExit = false;
        }

        Auth::login($user);
        if ($checkExit) {
            $level = 'user';
            if ($user->level_id === 2) {
                $level = 'censor';
            } else if ($user->level_id === 3) {
                $level = 'admin';
            }
            return redirect()->route("$level.welcome");
        }

        return redirect()->route('register')->with('message', 'Bạn cần nhập mật khẩu');
    }


    public function login()
    {
        return view('login');
    }

    public function logining(Request $request)
    {
        $request->validate([
            'email' => 'email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = User::where('email', $request->get('email'))->first();
            Auth::login($user);

            $level = 'user';
            if ($user->level_id === 2) {
                $level = 'censor';
            } else if ($user->level_id === 3) {
                $level = 'admin';
            }
            return redirect()->route("$level.index");
        } else {
            return redirect()->route('login')->with('error', 'Tài khoản hoặc mật khẩu không đúng');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect()->route('login');
    }

    public function register()
    {
        return view('register');
    }

    public function registering(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
            ],
            'name' => [
                'required',
                'string',
            ],
            'password' => [
                'required',
            ]
        ]);
        $password = Hash::make($request->get('password'));
        if (auth()->check()) {
            User::query()->where('email', Auth::user()->email)
                ->update([
                    'password' => $password,
                    'name' => $request->get('name'),
                ]);
        } else {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $password,
            ]);
            Auth::login($user);
        }
        return redirect()->route('user.index');
    }
}
