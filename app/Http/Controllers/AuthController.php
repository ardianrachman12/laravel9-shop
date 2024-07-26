<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $remember = $request->remember? true : false;

        $infoLogin = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'email wajib diisi',
            'password.required' => 'password wajib diisi',
        ]);

        if (Auth::attempt($infoLogin, $remember) and auth()->user()->role == 'admin') {
            $request->session()->regenerate();
            return redirect('dashboard');
        }
        if (Auth::attempt($infoLogin, $remember) and auth()->user()->role == 'member') {
            $request->session()->regenerate();
            return redirect('/');
        } else {
            return redirect()->route('auth.login')->withErrors('Email atau Password salah')->withInput();
        }
    }

    public function register()
    {
        return view('auth.register');
    }


    public function registerStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'no_hp' => 'required',
        ], [
            'name.required' => 'Nama diperlukan.',
            'name.min' => 'Nama harus memiliki setidaknya 5 karakter.',
            'email.required' => 'Email diperlukan.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password diperlukan.',
            'no_hp.required' => 'Nomor HP diperlukan.',
        ]);

        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator)->withInput();
        }

        $request['password'] = bcrypt($request->password);
        $request['role'] = "member";

        User::create($request->all());

        return redirect()->route('auth.login')->with('success', 'berhasil register');
    }


    public function logout(Request $request)
    {
        if ((Auth::check())) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login');
        }
        if ((Auth::check())) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('auth.login');
        }
    }

    public function forgotPasswordPage()
    {
        return view('auth.forgot-password');
    }


    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $guard = $this->getGuard($request->input('email'));

        $status = Password::broker($guard)->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->back()->with('success', 'berhasil send link')
            : redirect()->back()->withErrors(['email' => __($status)]);
    }

    protected function getGuard($email)
    {
        // Cek apakah email terdapat di dalam tabel 'members'
        // if (Member::where('email', $email)->first()) {
        //     return 'members';
        // }

        // Jika tidak, default ke guard 'web'
        return 'users';
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        $guard = $this->getGuard($request->input('email'));

        $status = Password::broker($guard)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'berhasil reset password')
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Validasi bahwa current_password sama dengan password lama
                    if (Auth::check()) {
                        $user = Auth::user();
                    }
                    if (!Hash::check($value, $user->password)) {
                        $fail('Password saat ini tidak valid.');
                    }
                },
            ],
            'new_password' => 'required|min:4',
            'confirm_password' => 'required|same:new_password'
        ], [
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'new_password.min' => 'Password baru minimal harus 4 karakter',
            'confirm_password.required' => 'Konfirmasi Password baru wajib diisi',
            'confirm_password.same' => 'Konfirmasi Password baru harus sama dengan Password baru'
        ]);

        if ($validator->fails()) {
            if (Auth::user()->role == "admin") {
                return redirect('/profile-admin')->withErrors($validator)->withInput();
            }else {
                return redirect('/profile')->withErrors($validator)->withInput();
            }
        }

        if (Auth::user()->role == "admin") {
            $user = Auth::guard('web')->user();
            // Ubah sandi user
            $user = User::where('email', $user->email)->first();
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect('/profile-admin')->with('success', 'Password berhasil diubah');
        }
        // Periksa apakah pengguna terautentikasi (pengguna member)
        elseif (Auth::user()->role == 'member') {
            $user = Auth::user();
            $user = User::where('email', $user->email)->first();
            $user->password = bcrypt($request->new_password);
            $user->save();
            return redirect('/profile')->with('success', 'Password berhasil diubah');
        }
        // Jika tidak ada pengguna terautentikasi, redirect atau berikan respon sesuai kebutuhan
        else {
            return redirect()->route('login')->withErrors('Anda belum login.');
        }
    }
}
