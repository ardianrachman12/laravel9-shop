<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //add to cart
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        $product = Product::where('id', $request->product_id)->first();

        if ($request->qty > $product->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok kurang.'
            ], 400);
        }

        $order_cek = Order::where('user_id', auth()->user()->id)->where('status', 0)->first();

        if (empty($order_cek)) {
            $order = new Order;
            $order->user_id = auth()->user()->id;
            $order->status = 0;
            $order->total_berat = 0;
            $order->total_harga = 0;
            $order->kode = 'INV/' . date('Ymd') . '/' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
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

        $order_new = Order::where('user_id', auth()->user()->id)->where('status', 0)->first();

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
                return response()->json([
                    'success' => false,
                    'message' => 'Produk pada keranjang melebihi stok.'
                ], 400);
            } else {
                $order_detail->qty = $order_detail->qty + $request->qty;
            }
            $new_harga = $product->harga * $request->qty;
            $new_berat = $product->berat * $request->qty;
            $order_detail->jumlah_berat = $order_detail->jumlah_berat + $new_berat;
            $order_detail->jumlah_harga = $order_detail->jumlah_harga + $new_harga;
            $order_detail->update();
        }

        $order = Order::where('user_id', auth()->user()->id)->where('status', 0)->first();
        $order->total_berat = $order->total_berat + $product->berat * $request->qty;
        $order->total_harga = $order->total_harga + $product->harga * $request->qty;
        $order->grand_total = $order->grand_total + $product->harga * $request->qty;
        $order->update();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ditambahkan ke keranjang',
            'data' => [$order_detail, $product]
        ], 200);
    }
}
