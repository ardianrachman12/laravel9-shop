@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
    @include('layouts.alert')
    <div class="card mb-2">
        <div class="card-header">
            <h4 class="card-title">Informasi Pembeli</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $order->users->name }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>: {{ $order->users->email }}</td>
                    </tr>
                    <tr>
                        <td>Phone</td>
                        <td>: {{ $order->users->no_hp }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <h4 class="card-title">Informasi Pengiriman</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Nama depan</td>
                        <td>: {{ $order->nama_depan }}</td>
                    </tr>
                    <tr>
                        <td>Nama belakang</td>
                        <td>: {{ $order->nama_belakang }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $order->alamat_detail }}</td>
                    </tr>
                    <tr>
                        <td>Kota/Kabupaten</td>
                        <td>: {{ $order->kota }}</td>
                    </tr>
                    <tr>
                        <td>Provinsi</td>
                        <td>: {{ $order->provinsi }}</td>
                    </tr>
                    <tr>
                        <td>Kode Pos</td>
                        <td>: {{ $order->kode_pos }}</td>
                    </tr>
                    <tr>
                        <td>Resi</td>
                        <td>: {{ $order->resi }}</td>
                    </tr>
                    <tr>
                        <td>Kurir</td>
                        <td>: {{ $order->kurir }} - {{ $order->service }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <h4 class="card-title">Informasi Pesanan</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <tbody>
                    <tr>
                        <td>Kode Invoice</td>
                        <td>: {{ $order->kode }}</td>
                    </tr>
                    <tr>
                        <td>Order Items</td>
                        <td></td>
                    </tr>
                    @foreach ($orderdetail as $item)
                        <tr class="table-secondary">
                            <td>{{ $loop->iteration }}. {{ $item->products->nama }} | qty : {{ $item->qty }} | Rp.
                                {{ $item->jumlah_harga }}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td>Status Order</td>
                        <td>: {{ $order->status }}</td>
                    </tr>
                    <tr>
                        <td>Subtotal</td>
                        <td>: Rp. {{ $order->total_harga }}</td>
                    </tr>
                    <tr>
                        <td>Biaya Pengiriman</td>
                        <td>: Rp. {{ $order->ongkir }}</td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td>: Rp. {{ $order->grand_total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-2">
        <div class="card-header">
            <h4 class="card-title">Informasi Pembayaran</h4>
        </div>
        <div class="card-body">
            <table class="table">
                @if ($order->status_pembayaran == 0)
                    <tbody>
                        <tr>
                            <td>Status Pembayaran</td>
                            <td>: UNPAID</td>
                        </tr>
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td>Method</td>
                            <td>: {{ $payment->method }}</td>
                        </tr>
                        <tr>
                            <td>Payment Type</td>
                            <td>: {{ $payment->payment_type }}</td>
                        </tr>
                        <tr>
                            <td>VA Number</td>
                            <td>: {{ $payment->va_number }}</td>
                        </tr>
                        <tr>
                            <td>Vendor Name</td>
                            <td>: {{ $payment->vendor_name }}</td>
                        </tr>
                        <tr>
                            <td>Payment Status</td>
                            <td>: {{ $payment->status }}</td>
                        </tr>
                        <tr>
                            <td>Payment Date/Time</td>
                            <td>: {{ $payment->updated_at }}</td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection
