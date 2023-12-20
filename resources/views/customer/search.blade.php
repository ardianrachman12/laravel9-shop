@extends('layouts.home.app-home')
@section('content')
    <section class="mt-5">
        @include('layouts.alert')
        <div class="container-fluid" data-aos="fade-in">
            <div class="mb-4">
                <h1 class="fw-bold fs-3 mb-2">Products Search</h1>
            </div>
            @if ($product->isEmpty())
                <p>Produk tidak ditemukan.</p>
            @else
            <div class="row g-4">
                @foreach ($product as $produk)
                    <div class="col-6 col-sm-3 col-lg-3">
                        <!-- Card Product-->
                        <div class="card border border-transparent position-relative overflow-hidden h-100 transparent">
                            <div class="card-img position-relative">
                                @include('layouts.home.badge')
                                <span class="position-absolute top-0 end-0 p-2 z-index-20 text-muted"><i
                                        class="ri-heart-line"></i></span>
                                <picture class="position-relative overflow-hidden d-block bg-light">
                                    <img class="w-100 img-fluid position-relative z-index-10" title=""
                                        src="/uploads/{{ $produk->gambar }}" alt="img">
                                </picture>
                            </div>
                            <div class="card-body px-0">
                                <a class="text-decoration-none link-cover" href="{{ route('home.product-detail', ['id' => $produk->id]) }}">{{ $produk->nama }}</a>
                                {{-- <small class="text-muted d-block">{{ $produk->deskripsi }}</small> --}}
                                <p class="mt-2 mb-0 small">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--/ Card Product-->
            </div>
            @endif
        </div>
    </section>
@endsection
