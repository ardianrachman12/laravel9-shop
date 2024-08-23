<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('auth.login');
        }
    }
    public function handle($request, Closure $next, ...$guards)
    {
        if (!Auth::check()) {
            // Jika pengguna belum login, buat akun guest
            $guestUser = User::create([
                'name' => 'Guest_' . Str::random(5),
                'role' => 'guest',
            ]);

            // Login sebagai guest user
            Auth::login($guestUser);
        }

        return $next($request);
    }
    // protected function unauthenticated($request, array $guards)
    // {
    //     // Logika untuk menentukan apakah ini permintaan dari API
    //     if ($request->is('api/*') || $request->expectsJson()) {
    //         return response()->json(['message' => 'Unauthenticated. Please login first.'], 401);
    //     }

    //     // Default ke redirect untuk client (web)
    //     return redirect()->guest($this->redirectTo($request));
    // }
}
