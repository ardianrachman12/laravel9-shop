<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (!auth('member')->check()) {
            // If not authenticated, redirect to the login page
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu.');
        }
        $profil = Auth::guard('member')->user();

        if ($profil) {
            // Cari pesanan berdasarkan member_id
            $order = Order::where('member_id', $profil->id)->where('status', 0)->first();
            $address = Address::where('member_id', $profil->id)->first();

            if (!$order) {
                return back()->with('warning', 'Keranjang belanja Anda masih kosong.');
            } else {
                // Jika pesanan ditemukan, ambil detail pesanan
                $orderdetail = Orderdetail::with('orders', 'products')->where('order_id', $order->id)->get();
            }
        }

        $category = Category::all();
        $sub = Subcategory::all();
        // $orderdetail = Orderdetail::all();
        return view('customer.cart', compact('category', 'sub', 'order', 'orderdetail', 'address'));
    }

    public function orderStore(Request $request, $id)
    {

        if (!auth('member')->check()) {
            // If not authenticated, redirect to the login page
            return redirect()->route('login')->with('warning', 'Silakan login terlebih dahulu.');
        }

        $product = Product::where('id', $id)->first();

        if ($request->qty > $product->stok) {
            return redirect()->back()->with('warning', 'Stok kurang');
        }


        $order_cek = Order::where('member_id', auth('member')->user()->id)->where('status', 0)->first();

        if (empty($order_cek)) {
            $order = new Order;
            $order->member_id = auth('member')->user()->id;
            $order->status = 0;
            $order->total_berat = 0;
            $order->total_harga = 0;
            $order->kode = $order->kode = 'INV/' . date('Ymd') . '/' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $order->ongkir = 0;
            $order->kurir = '';
            $order->service = '';
            $order->resi = '';
            $order->grand_total = 0;
            $order->nama_depan = '';
            $order->nama_belakang = '';
            $order->alamat_detail = '';
            $order->provinsi = '';
            $order->kota = '';
            $order->kode_pos = '';
            $order->status_pembayaran = 0;
            $order->save();
        }

        $order_new = Order::where('member_id', auth('member')->user()->id)->where('status', 0)->first();

        $order_detail_cek = Orderdetail::where('product_id', $product->id)->where('order_id', $order_new->id)->first();

        if (empty($order_detail_cek)) {
            $order_detail = new Orderdetail;
            $order_detail->product_id = $product->id;
            $order_detail->order_id = $order_new->id;
            $order_detail->qty = $request->qty;
            $order_detail->jumlah_berat = $product->berat * $request->qty;
            $order_detail->jumlah_harga = $product->harga * $request->qty;
            $order_detail->save();
        } else {
            $order_detail = Orderdetail::where('product_id', $product->id)->where('order_id', $order_new->id)->first();
            $sisa = $product->stok - $order_detail->qty;
            if ($request->qty > $sisa) {
                return redirect()->back()->with('warning', 'Produk pada keranjang melebihi stok');
            } else {
                $order_detail->qty = $order_detail->qty + $request->qty;
            }
            $new_harga = $product->harga * $request->qty;
            $new_berat = $product->berat * $request->qty;
            $order_detail->jumlah_berat = $order_detail->jumlah_berat + $new_berat;
            $order_detail->jumlah_harga = $order_detail->jumlah_harga + $new_harga;
            $order_detail->update();
        }

        $order = Order::where('member_id', auth('member')->user()->id)->where('status', 0)->first();
        $order->total_berat = $order->total_berat + $product->berat * $request->qty;
        $order->total_harga = $order->total_harga + $product->harga * $request->qty;
        $order->grand_total = $order->grand_total + $product->harga * $request->qty;
        $order->update();

        // return response()->json([
        //     'message' => 'berhasil tambah keranjang'
        // ]);

        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang');
    }

    // public function updateproduct(Request $request, $id)
    // {
    //     $product = Product::where('id', $id)->first();

    //     if ($request->qty > $product->stok) {
    //         return redirect()->back()->with('warning', 'Stok kurang');
    //     }else {
    //         $order = Order::where('member_id', auth('member')->user()->id)->where('status', 0)->first();
    //         $order_detail = Orderdetail::where('product_id', $product->id)->where('order_id', $order->id)->first();

    //         $order_detail->qty = $request->qty;
    //         $new_harga = $product->harga * $request->qty;
    //         $new_berat = $product->berat * $request->qty;
    //         $order_detail->update();
    //     }
    // }

    public function deleteproduct($id)
    {
        $orderdetails = Orderdetail::findOrFail($id);
        $hargakurang = $orderdetails->jumlah_harga;
        $beratkurang = $orderdetails->jumlah_berat;

        $order = Order::where('member_id', auth('member')->user()->id)->where('status', 0)->first();
        $order->total_harga = $order->total_harga - $hargakurang;
        $order->total_berat = $order->total_berat - $beratkurang;
        $order->update();

        $orderdetails->delete();

        // Periksa apakah masih ada produk di keranjang belanja
        $remainingProducts = Orderdetail::where('order_id', $order->id)->count();

        if ($remainingProducts == 0) {
            $order->delete();
            return redirect()->route('home')->with('warning', 'Keranjang belanja Anda kosong.');
        } else {
            return redirect()->back()->with('success', 'Berhasil hapus produk');
        }
    }
}
