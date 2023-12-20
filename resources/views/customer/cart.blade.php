@extends('layouts.home.app-home')
@section('content')
    <!-- Main Section-->
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    <section class="overflow-lg-hidden vh-lg-auto">
        <!-- Page Content Goes Here -->
        <div class="container">
            <div class="row g-0 vh-lg-auto">
                <div class="col-12 col-lg-7 pt-1">
                    <div class="pe-lg-5">
                        <div class="mt-2">
                            <h3 class="fs-5 fw-bolder mb-0 border-bottom pb-4">Your Cart</h3>
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <tbody class="border-0">
                                        @foreach ($orderdetail as $orders)
                                            <div class="row mx-0 py-4 g-0 border-bottom">
                                                <div class="col-2 position-relative">
                                                    <picture class="d-block border">
                                                        <a
                                                            href="/product-subcategories/product-detail/{{ $orders->product_id }}">
                                                            <img class="img-fluid"
                                                                src="/uploads/{{ $orders->products->gambar }}"
                                                                alt="product image">
                                                        </a>
                                                    </picture>
                                                </div>
                                                <div class="col-9 offset-1">
                                                    <div>
                                                        <h6 class="justify-content-between d-flex align-items-start mb-2">
                                                            {{ $orders->products->nama }}
                                                            <form action="{{ route('deleteproduct', $orders->id) }}"
                                                                type="button" method="post"
                                                                onsubmit="return confirm('Yakin akan dihapus?')">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-sm">
                                                                    <i class="ri-close-line"></i>
                                                                </button>
                                                            </form>
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
                                        <!-- Cart Item-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 bg-light pt-lg-5 aside-checkout pb-5 pb-lg-0 my-5 my-lg-0">
                    <div class="p-4 py-lg-0 pe-lg-0 ps-lg-5">
                        <div class="pb-4 border-bottom">
                            <div class="d-flex flex-column flex-md-row justify-content-md-between mb-4 mb-md-2">
                                <div>
                                    <p class="m-0 fw-bold fs-5">Order Total</p>
                                    {{-- <span class="text-muted small">Inc $45.89 sales tax</span> --}}
                                </div>
                                <p class="m-0 fs-5 fw-bold">Rp. {{ $orders->orders->total_harga }}</p>
                            </div>
                        </div>
                        {{-- <div class="py-4">
                            <div class="input-group mb-0">
                                <input type="text" class="form-control" placeholder="Enter coupon code">
                                <button class="btn btn-secondary btn-sm px-4">Apply</button>
                            </div>
                        </div> --}}
                        <a @if ($address) href="{{ route('shipping') }}" @else href="{{ route('profil') }}" onclick="return confirm('Silahkan isi alamat dahulu');" @endif
                            class="btn btn-dark w-100 text-center" role="button">Proceed to
                            checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </section>
    <!-- / Main Section-->
@endsection
