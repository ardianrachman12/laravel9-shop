<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoice;
use App\Models\Address;
use App\Models\Category;
use App\Models\City;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Product;
use App\Models\Province;
use App\Models\Subcategory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{


    public function shipping()
    {
        $profil = Auth::guard('member')->user();
        if ($profil) {
            $nama = $profil->nama;
            $email = $profil->email;
            $address = Address::where('member_id', $profil->id)->first();
            $order = Order::where('member_id', $profil->id)->where('status', 0)->first();
            $orderdetail = Orderdetail::with('orders', 'products')->where('order_id', $order->id)->get();
        }

        $origin = 39; //kab. bantul
        $availableCouriers = ['jne', 'pos', 'tiki'];

        $results = [];

        foreach ($availableCouriers as $courier) {
            $responsecost = Http::withHeaders([
                'key' => config('rajaongkir.api_key')
            ])->post('https://api.rajaongkir.com/starter/cost', [
                'origin' => $origin,
                'destination' => $address->city_id,
                'courier' => $courier,
                'weight' => $order->total_berat,
            ]);

            $results[$courier] = $responsecost->json()['rajaongkir']['results'][0]['costs'];
        }
        // dd($results);

        $category = Category::all();
        $sub = Subcategory::all();
        $provinces = Province::all();
        $cities = City::all();

        return view('customer.checkout', compact('nama', 'email', 'address', 'category', 'sub', 'cities', 'provinces', 'order', 'orderdetail', 'responsecost', 'results'));
    }

    public function placeorder(Request $request)
    {
        $profil = Auth::guard('member')->user();
        if ($profil) {
            $address = Address::where('member_id', $profil->id)->first();
        }

        $order = Order::where('member_id', auth('member')->user()->id)->where('status', 0)->first();

        $order->status = 1;
        $serviceData = explode('|', $request->service);
        $order->kurir = strtoupper($serviceData[0]);
        $order->service =  $serviceData[1];
        $order->ongkir =  (int)$serviceData[2];
        $order->grand_total = $order->grand_total + (int)$serviceData[2];
        $order->nama_depan = $address->nama_depan;
        $order->nama_belakang = $address->nama_belakang;
        $order->alamat_detail = $address->alamat_detail;
        $order->provinsi = $address->Provinces->title;
        $order->kota = $address->Cities->title;
        $order->kode_pos = $address->kode_pos;

        $order->update();

        // Update product stock based on order details
        $orderDetails = Orderdetail::where('order_id', $order->id)->get();

        foreach ($orderDetails as $detail) {
            $product = Product::find($detail->product_id);
            if ($product) {
                // Decrease product stock based on the quantity in the order detail
                $product->stok -= $detail->qty;
                $product->update();
            }
        }
        return redirect()->route('orderconfirm', $order->id);
    }

    public function orderconfirm(String $id)
    {
        $category = Category::all();
        $sub = Subcategory::all();

        $profil = Auth::guard('member')->user();
        if ($profil) {
            $address = Address::where('member_id', $profil->id)->first();
            $order = Order::where('member_id', $profil->id)->where('status', 1)->findOrFail($id);
            $orderdetail = Orderdetail::where('order_id', $order->id)->get();
        }
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->kode,
                'gross_amount' => $order->grand_total,
            ),
            'customer_details' => array(
                'first_name' => $order->nama_depan,
                'last_name' => $order->nama_belakang,
                'email' => $profil->email,
                'phone' => $profil->no_hp,
            ),
        );

        $snapToken = \Midtrans\Snap::createTransaction($params);

        $redirect = $snapToken->redirect_url;

        // dd($snapToken);

        return view('customer.order-confirm', compact('category', 'sub', 'order', 'address', 'orderdetail', 'snapToken', 'redirect'));
    }

    public function orderlist()
    {
        $category = Category::all();
        $sub = Subcategory::all();

        $profil = Auth::guard('member')->user();
        if ($profil) {
            $order = Order::where('member_id', $profil->id)
                ->where('status', '<>', 0) // Menambahkan kondisi status tidak sama dengan 0
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        foreach ($order as $items) {
            if ($items->status == 1 & $items->status_pembayaran == 0) {
                $items->status = 'Pesanan baru';
            }else if ($items->status == 1 & $items->status_pembayaran == 1) {
                $items->status = 'Pesanan Dibayar';
            } else if ($items->status == 2) {
                $items->status = 'Pesanan Dikemas';
            } else if ($items->status == 3) {
                $items->status = 'Pesanan Dikirim';
            } else if ($items->status == 4) {
                $items->status = 'Pesanan Diterima';
            } else {
                $items->status = 'Pesanan Dicancel';
            }
        }
        return view('customer.order-list', compact('order', 'sub', 'category'));
    }

    public function orderinfo($id)
    {
        $category = Category::all();
        $sub = Subcategory::all();

        $profil = Auth::guard('member')->user();
        if ($profil) {
            $address = Address::where('member_id', $profil->id)->first();
            $order = Order::where('member_id', $profil->id)->findOrFail($id);
            $orderdetail = Orderdetail::where('order_id', $order->id)->get();
        }

        if ($order->status == 1 & $order->status_pembayaran == 0) {
            $order->status = 'pesanan baru';
        }else if ($order->status == 1 & $order->status_pembayaran == 1) {
            $order->status = 'pesanan dibayar';
        } else if ($order->status == 2) {
            $order->status = 'pesanan dikemas';
        } else if ($order->status == 3) {
            $order->status = 'pesanan dikirim';
        } else if ($order->status == 4) {
            $order->status = 'pesanan diterima';
        } else {
            $order->status = 'pesanan dicancel';
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $order->kode,
                'gross_amount' => $order->grand_total,
            ),
            'customer_details' => array(
                'first_name' => $order->nama_depan,
                'last_name' => $order->nama_belakang,
                'email' => $profil->email,
                'phone' => $profil->no_hp,
            ),
        );
        if ($order->status_pembayaran == 0) {
            $snapToken = \Midtrans\Snap::createTransaction($params);
            $redirect = $snapToken->redirect_url;
            $order->status_pembayaran = 'UNPAID';
            return view('customer.order-info', compact('order', 'sub', 'category', 'address', 'orderdetail', 'redirect'));
        } else {
            $order->status_pembayaran = 'PAID';
            return view('customer.order-info', compact('order', 'sub', 'category', 'address', 'orderdetail'));
        }
    }

    public function invoice()
    {
        $profil = Auth::guard('member')->user();
        if ($profil) {
            // $address = Address::where('member_id', $profil->id)->first();
            $order = Order::where('member_id', $profil->id)->first();
            // $orderdetail = Orderdetail::where('order_id', $order->id)->get();
        }
        if ($order->status == 1 & $order->status_pembayaran == 0) {
            $order->status = 'pesanan baru';
        }else if ($order->status == 1 & $order->status_pembayaran == 1) {
            $order->status = 'pesanan dibayar';
        } else if ($order->status == 2) {
            $order->status = 'pesanan dikemas';
        } else if ($order->status == 3) {
            $order->status = 'pesanan dikirim';
        } else if ($order->status == 4) {
            $order->status = 'pesanan diterima';
        } else {
            $order->status = 'pesanan dicancel';
        }
        // return view('customer.invoice',compact('order','orderdetail'));

        $pdf = Pdf::loadView('customer.invoice',['order' => $order]);
        return $pdf->download('invoice-'.$order->kode.'.pdf');
    }

    public function sendInvoice() {
        $user = Auth::guard('member')->user();
    
        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }
    
        $order = Order::where('member_id', $user->id)->first();
        // dd($order);
    
        if ($order->status == 1 && $order->status_pembayaran == 0) {
            $order->status = 'pesanan baru';
        } else if ($order->status == 1 && $order->status_pembayaran == 1) {
            $order->status = 'pesanan dibayar';
        } else if ($order->status == 2) {
            $order->status = 'pesanan dikemas';
        } else if ($order->status == 3) {
            $order->status = 'pesanan dikirim';
        } else if ($order->status == 4) {
            $order->status = 'pesanan diterima';
        } else {
            $order->status = 'pesanan dicancel';
        }
    
        try {
            Mail::to($user->email)->send(new SendInvoice($order));
            return redirect()->back()->with('success', 'Invoice berhasil dikirim ke email');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengirim invoice. Error: ' . $e->getMessage());
        }
    }
    

    // public function payment()
    // {
    //     $profil = Auth::guard('member')->user();
    //     if ($profil) {
    //         $address = Address::where('member_id', $profil->id)->first();
    //         $order = Order::where('member_id', $profil->id)->where('status', 1)->first();
    //         $orderdetail = Orderdetail::where('order_id', $order->id)->get();
    //     }

    //     // Set your Merchant Server Key
    //     \Midtrans\Config::$serverKey = config('midtrans.server_key');
    //     // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
    //     \Midtrans\Config::$isProduction = false;
    //     // Set sanitization on (default)
    //     \Midtrans\Config::$isSanitized = true;
    //     // Set 3DS transaction for credit card to true
    //     \Midtrans\Config::$is3ds = true;

    //     $params = array(
    //         'transaction_details' => array(
    //             'order_id' => $order->id,
    //             'gross_amount' => $order->grand_total,
    //         ),
    //         'customer_details' => array(
    //             'first_name' => $order->nama_depan,
    //             'last_name' => $order->nama_belakang,
    //             'email' => $profil->email,
    //             'phone' => $profil->no_hp,
    //         ),
    //     );

    //     $snapToken = \Midtrans\Snap::getSnapToken($params);
    //     return redirect()->back();
    // }

    // public function getapi()
    // {
    //     $response = Http::withHeaders([
    //         'key' => 'e271544682c40ec0c907bc1cdf903d5f'
    //     ])->get('https://api.rajaongkir.com/starter/city');
    //     $cities = $response['rajaongkir']['results'];
    //     return view('customer.cekongkir', compact('cities'));
    // }
    // public function getcost(Request $request)
    // {
    //     $profil = Auth::guard('member')->user();
    //     if ($profil) {
    //         $address = Address::where('member_id', $profil->id)->first();
    //         $order = Order::where('member_id', $profil->id)->first();
    //     }
    //     $origin = 39;
    //     $courier = 'jne';

    //     $responsecost = Http::withHeaders([
    //         'key' => 'e271544682c40ec0c907bc1cdf903d5f'
    //     ])->post('https://api.rajaongkir.com/starter/cost', [
    //         'origin' => $origin,
    //         'destination' => $address->city_id,
    //         'courier' => $courier,
    //         'weight' => $order->total_berat,
    //     ]);

    //     dd($responsecost->json());

    //     // $data = $responsecost['rajaongkir']['results'];
    //     // foreach($data as $data){
    //     //     echo "<option value='{$response['service']}'></option>";
    //     // }

    //     // $cities = $response['rajaongkir']['results'];
    //     // return view('customer.cekongkir', compact('cities'));
    // }
}
