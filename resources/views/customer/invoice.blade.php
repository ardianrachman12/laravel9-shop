<!DOCTYPE html>
<html lang="en">

<body style="font-family: Arial, sans-serif;">

    <div class="container" style="width: 80%; margin: 0 auto;">
        <div class="header" style="background-color: #f0f0f0; padding: 10px; text-align: center;">
            <h1>INVOICE</h1>
        </div>
        <div class="invoice-info" style="padding: 0; margin-top: 40px;">
            <h5 style="margin-top: -20px;">Invoice : {{ $order->kode }}</h5>
            <h5 style="margin-top: -20px;">Date/Time : {{ $order->created_at }}</h5>
            <h5 style="margin-top: -20px;">Status Pesanan : {{ $order->status }}</h5>
        </div>
        <div class="billing-info" style="padding-bottom: 10px; font-size: 10px;">
            <h2>Billing Information</h2>
            <p>Name: {{ $order->members->nama }}</p>
            <p>Email: {{ $order->members->email }}</p>
            <p>Phone: {{ $order->members->no_hp }}</p>
        </div>
        <div class="products" style="padding-bottom: 10px; font-size: 10px;">
            <h2>Products</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="background-color: #f0f0f0; text-align: left; padding: 10px;">Name</th>
                        <th style="background-color: #f0f0f0; text-align: left; padding: 10px;">Quantity</th>
                        <th style="background-color: #f0f0f0; text-align: left; padding: 10px;">Unit Price</th>
                        <th style="background-color: #f0f0f0; text-align: left; padding: 10px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderdetails as $data)
                        <tr>
                            <td style="padding:10px;">{{ $data->products->nama }}</td>
                            <td style="padding:10px;">{{ $data->qty }}</td>
                            <td style="padding:10px;">Rp. {{ $data->products->harga }}</td>
                            <td style="padding:10px;">Rp. {{ $data->jumlah_harga }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="padding:8px;"><b>Subtotal</b></td>
                        <td style="padding:8px;"><b>: Rp. {{ $order->total_harga }}</b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="padding:8px;"><b>Biaya Pengiriman</b></td>
                        <td style="padding:8px;"><b>: Rp. {{ $order->ongkir }}</b></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td style="padding:8px;"><b>Grand Total</b></td>
                        <td style="padding:8px;"><b>: Rp. {{ $order->grand_total }}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        @if ($order->status != 'pesanan dicancel' && $order->status != 'pesanan baru')
            <div class="shipping-info" style="padding-bottom: 10px; font-size: 10px;">
                <h2>Payment Information</h2>
                <p>Payment Type : {{ $order->payments->first()->payment_type }}</p>
                <p>Vendor : {{ $order->payments->first()->vendor_name }}</p>
                <p>Virtual Account : {{ $order->payments->first()->va_number }}</p>
                <p>Status Payment: {{ $order->payments->first()->status }}</p>
            </div>
            @else
            <div class="shipping-info" style="padding-bottom: 10px; font-size: 10px;">
                <h2>Payment Information</h2>
                <p>Status Payment: UNPAID</p>
            </div>
        @endif
        <div class="shipping-info" style="padding-bottom: 10px; font-size: 10px;">
            <h2>Shipping Information</h2>
            <p>Nama depan : {{ $order->nama_depan }}</p>
            <p>Nama belakang : {{ $order->nama_belakang }}</p>
            <p>Alamat : {{ $order->alamat_detail }}</p>
            <p>Kabupaten/Kota : {{ $order->kota }}</p>
            <p>Provinsi : {{ $order->provinsi }}</p>
            <p>Kurir : {{ $order->kurir }} {{ $order->service }}</p>
            <p>Resi : {{ $order->resi }}</p>
        </div>
        <div style="padding: 10px; text-align: center;">
            <p>Terimakasih telah berbelanja di toko kami</p>
        </div>
    </div>
</body>

</html>
