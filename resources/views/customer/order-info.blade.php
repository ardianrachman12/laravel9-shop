@extends('layouts.home.app-home')
@section('content')
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <div class="container-fluid">
        <div class="row g-0 vh-lg-auto">
            <div class="col-12 col-lg-7 pt-lg-5 pb-lg-5">
                <div class="p-4 py-lg-0 pe-lg-5 ps-lg-5">
                    <!-- Checkout Panel Information-->
                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-3">
                        <h3 class="fs-5 fw-bolder m-0 lh-1">shipment information</h3>
                    </div>
                    <div class="px-4">
                        <table>
                            <tr>
                                <td class="fw-bold">First Name</td>
                                <td>: {{ $address->nama_depan }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Last Name</td>
                                <td>: {{ $address->nama_belakang }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Email</td>
                                <td>: {{ $address->members->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Phone</td>
                                <td>: {{ $address->members->no_hp }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Address</td>
                                <td>: {{ $order->alamat_detail }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-7 pb-lg-5">
                <div class="p-4 py-lg-0 pe-lg-5 ps-lg-5">
                    <!-- Checkout Panel Information-->
                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-3">
                        <h3 class="fs-5 fw-bolder m-0 lh-1">order information</h3>
                    </div>
                    <div class="row mx-0 py-4 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Invoice
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end m-0">
                                {{ $order->kode }}
                            </p>
                        </div>
                    </div>
                    @foreach ($orderdetail as $orders)
                        <div class="row mx-0 py-2 g-0 border-bottom mb-4">
                            <div class="col-2 position-relative">
                                <picture class="d-block border">
                                    <img class="img-fluid" src="/uploads/{{ $orders->products->gambar }}"
                                        alt="HTML Bootstrap Template by Pixel Rocket">
                                </picture>
                            </div>
                            <div class="col-9 offset-1">
                                <div>
                                    <h6 class="justify-content-between d-flex align-items-start">
                                        {{ $orders->products->nama }}
                                    </h6>
                                    <span class="d-block text-muted fw-bolder text-uppercase fs-10">
                                        Qty : {{ $orders->qty }}
                                    </span>
                                </div>
                                <p class="fw-bolder text-end text-muted m-0">Rp.
                                    {{ $orders->jumlah_harga }}
                                </p>
                            </div>
                        </div> <!-- / Cart Item-->
                    @endforeach
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start">
                                Subtotal
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">: Rp.
                                {{ $order->total_harga }}
                            </p>
                        </div>
                    </div>
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start">
                                Shipping cost
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">: Rp.
                                {{ $order->ongkir }}
                            </p>
                        </div>
                    </div>
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Grand Total
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">: Rp.
                                {{ $order->grand_total }}
                            </p>
                        </div>
                    </div>
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Payment Status
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">:
                                {{ $order->status_pembayaran }}
                            </p>
                        </div>
                    </div>
                    <div class="row mx-0 g-0">
                        <div class="col-2 position-relative">
                            <h6 class="justify-content-between d-flex align-items-start mb-2">
                                Order Status
                            </h6>
                        </div>
                        <div class="col-9 offset-1">
                            <p class="fw-bolder text-end text-muted m-0">:
                                {{ $order->status }}
                            </p>
                        </div>
                    </div>
                    <div class="py-2 mt-4 border-top d-flex justify-content-md-start align-items-center">
                        <a href="{{ route('invoice', $order->id) }}" class="btn btn-dark" type="button"><span><i class="ri-printer-line"></i></span> 
                            Invoice</a>
                        <a href="/send-invoice" class="btn btn-dark ms-2" type="button"><span><i class="ri-mail-send-line"></i></span>
                            Invoice</a>
                        @if ($order->status == 'pesanan dikirim')
                            <form action="{{ route('delivered', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success ms-2">Terima Pesanan</button>
                            </form>
                        @endif
                        @if ($order->status == 'pesanan baru' && $order->status_pembayaran == 'UNPAID')
                        <div class="ms-2">
                            <a href="{{ $redirect }}" class="btn btn-dark" type="button">Pay Now</a>
                        </div>
                        @endif
                        @if ($order->status == 'pesanan baru')
                            <form action="{{ route('cancel', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger ms-2">Cancel</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
