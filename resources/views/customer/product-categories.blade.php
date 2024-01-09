@extends('layouts.home.app-home')
@section('content')
    <div class="bg-dark py-4">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $categories->nama }}</li>
                </ol>
            </nav>
            <h1 class="fw-bold fs-3 text-light text-uppercase">{{ $categories->nama }}</h1>
        </div>
    </div>
    <div class="container-fluid mb-4">
        @include('layouts.alert')
    </div>
    @foreach ($subcategory as $subcategory)
        <section class="mt-2">
            <div class="container-fluid" data-aos="fade-in">
                <!-- Category Toolbar-->
                <div class="d-flex justify-content-between items-center pt-2 pb-4 flex-column flex-lg-row">
                    <div>
                        <h1 class="fw-bold fs-3 mb-2">{{ $subcategory->nama }}</h1>
                        <p class="m-0 text-muted small">Showing {{ $subcategory->products->count() }} of {{ $subcategory->products->count() }}</p>
                    </div>
                </div>
                <!-- /Category Toolbar-->
                <!-- Products-->
                <div class="row g-4">
                    @foreach ($subcategory->products->take(4) as $produk)
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
                                    <a class="text-decoration-none link-cover"
                                        href="{{ route('home.product-detail', ['id' => $produk->id]) }}">{{ $produk->nama }}</a>
                                    {{-- <small class="text-muted d-block">{{ $produk->deskripsi }}</small> --}}
                                    <p class="mt-2 mb-0 small"><span class="text">Rp.{{ $produk->harga }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <!--/ Card Product-->
                    <!-- / Products-->
                </div>
                <div
                    class="d-flex justify-content-end align-items-center mt-4 mt-lg-0 flex-column flex-md-row border-bottom pb-4">
                    <a href="/product-subcategories/{{$subcategory->id}}" class="btn btn-outline-dark btn-sm py-3 px-4 border-2">Load More</a>
                </div>
            </div>
            <!-- /Page Content -->
        </section>
    @endforeach
@endsection
