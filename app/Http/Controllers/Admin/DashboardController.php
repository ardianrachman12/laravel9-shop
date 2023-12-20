<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Ambil data total harga per bulan
            $total_harga = Order::select(DB::raw("CAST(SUM(total_harga) as UNSIGNED) as total_harga"))
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->pluck('total_harga')
                ->toArray();

            // Ambil data nama bulan
            $bulan = Order::select(DB::raw("MONTHNAME(created_at) as bulan"))
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('bulan')
                ->toArray();

            // dd($bulan, $total_harga);
            $product = Product::where('stok', 0)->get();
            return view('dashboard', compact('total_harga', 'bulan', 'product'));
        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return "Error: " . $e->getMessage();
        }
    }

    public function profileAdmin()
    {
        $data = Auth::guard('web')->user();
        return view('profile', compact('data'));
    }

    public function updateProfile(Request $request)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::guard('web')->user();

        // Membuat validator untuk data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id, // Memastikan email unik kecuali untuk pengguna saat ini
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Memperbarui data pengguna
        $user->name = $request->name;
        $user->email = $request->email;
        $user->update();

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
}
