<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\City;
use App\Models\Member;
use App\Models\Province;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $category = Category::all();
        $sub = Subcategory::all();
        $profil = Auth::guard('member')->user();
        if ($profil) {
            $nama = $profil->nama;
            $email = $profil->email;
            $no_hp = $profil->no_hp;
            $address = Address::where('member_id', $profil->id)->first();
        }

        $provinces = Province::all();
        $cities = City::all();

        return view('customer.profile.index', compact('nama', 'email', 'no_hp', 'category', 'sub', 'profil', 'cities', 'provinces', 'address'));
    }

    public function updateProfile(Request $request)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = Auth::guard('member')->user();

        // Membuat validator untuk data yang diterima dari request
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $user->id, // Memastikan email unik kecuali untuk pengguna saat ini
            'no_hp' => 'required|string|max:255',
        ]);

        // Jika validasi gagal, kembalikan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Memperbarui data pengguna
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->update();

        // Redirect ke halaman profil dengan pesan sukses
        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }
    public function createAddress(Request $request)
    {
        $memberId = auth('member')->user()->id;
        Address::create(array_merge($request->all(), ['member_id' => $memberId]));
        return back()->with('success', 'Berhasil menambahkan alamat');
    }
    public function updateAddress(Request $request, String $id)
    {
        $address = Address::findOrFail($id);
        $address->update($request->all());
        return redirect()->route('profil')->with('success', 'Berhasil memperbarui alamat');
    }
    public function editProfil($id)
    {
    }
    public function editAddress(String $id)
    {
        $category = Category::all();
        $sub = Subcategory::all();
        $provinces = Province::all();
        $cities = City::all();
        $address = Address::findOrFail($id);

        return view('customer.profile.edit-address', compact('address', 'category', 'sub', 'cities', 'provinces'));
    }

    public function selectprovinsi(Request $request)
    {
        $id_province = $request->id_province;
        $cities = City::where('province_id', $id_province)->get();

        foreach ($cities as $city) {
            echo "<option value='{$city->id}'>{$city->title}</option>";
        }
    }

    public function selectCity(Request $request)
    {
        $id_destination = $request->id_destination;
        $city = City::findOrFail($id_destination);

        return response()->json(['postal_code' => $city->postal_code]);
    }
}
