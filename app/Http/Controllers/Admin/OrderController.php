<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\Orderdetail;
use App\Models\Payment;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function pesananbaru()
    {
        $order = Order::with('payments')->where('status', 1)->where('status_pembayaran', 0)->get();
        return view('order.pesanan-baru', compact('order'));
    }
    public function pesananbayar()
    {
        $order = Order::with('payments')->where('status', 1)->where('status_pembayaran', 1)->get();
        return view('order.pesanan-dibayar', compact('order'));
    }
    public function pesanankemas()
    {
        $order = Order::with('payments')->where('status', 2)->get();
        return view('order.pesanan-dikemas', compact('order'));
    }
    public function pesanankirim()
    {
        $order = Order::with('payments')->where('status', 3)->get();
        return view('order.pesanan-dikirim', compact('order'));
    }
    public function pesananterima()
    {
        $order = Order::with('payments')->where('status', 4)->get();
        return view('order.pesanan-diterima', compact('order'));
    }

    public function pesanancancel()
    {
        $order = Order::with('payments')->where('status', 5)->get();
        return view('order.pesanan-dicancel', compact('order'));
    }
    public function detailpesanan($id)
    {
        $order = Order::with('addresses', 'users')->findOrFail($id);
        $payment = Payment::where('order_id', $order->id)->first();

        if ($order->status == 1 & $order->status_pembayaran == 0) {
            $order->status = 'pesanan baru';
        } else if ($order->status == 1 & $order->status_pembayaran == 1) {
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

        $orderdetail = Orderdetail::with('products')->where('order_id', $order->id)->get();
        return view('order.detail-pesanan', compact('order', 'orderdetail', 'payment'));
    }
    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->update();
        return redirect()->back()->with('success', 'berhasil konfirmasi pesanan');
    }
    public function inputresi(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 3;
        $order->resi = $request->input('resi');
        $order->update();
        return redirect()->back()->with('success', 'berhasil input resi pesanan');
    }
    
    public function cancel($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 5;
        $order->update();
        return redirect()->back()->with('success', 'berhasil cancel pesanan');
    }
    
    public function delivered($id){
        $order = Order::findOrFail($id);
        $order->status = 4;
        $order->update();
        return redirect()->back()->with('success', 'pesanan berhasil diterima');
    }

    public function addCost(Request $request, $id){
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->ongkir = $request->input('ongkir');
        $order->grand_total = $order->grand_total + $request->input('ongkir') - $request->input('diskon');
        $order->update();
        return redirect()->back()->with('success', 'pesanan berhasil dikonfirmasi');
    }
}
