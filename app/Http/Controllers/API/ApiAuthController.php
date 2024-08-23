<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email diperlukan.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password diperlukan.',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'message' => 'Berhasil Login'
        ]);
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
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $request['password'] = bcrypt($request->password);
        $request['role'] = "member";

        User::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Berhasil register',
            'data' => $request->all()
        ], 201);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
