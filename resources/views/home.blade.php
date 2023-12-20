@extends('layouts.home.app-home')
@section('content')
    <div class="container-fluid">
        @include('layouts.alert')
    </div>
    @include('layouts.home.slider')
    <!-- Main Section-->

    <section class="mt-5">
        <div class="container-fluid" data-aos="fade-in">
            <!-- Category Toolbar-->
            <div class="d-flex justify-content-between items-center pt-5 pb-4 flex-column flex-lg-row">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Product List</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold fs-3 mb-2">New Products List</h1>
                    <p class="m-0 text-muted small">Showing 1 - 9 of 121</p>
                </div>
                {{-- <div class="d-flex justify-content-end align-items-center mt-4 mt-lg-0 flex-column flex-md-row">

                    <!-- Filter Trigger-->
                    <button
                        class="btn bg-light p-3 me-md-3 d-flex align-items-center fs-7 lh-1 w-100 mb-2 mb-md-0 w-md-auto "
                        type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilters"
                        aria-controls="offcanvasFilters">
                        <i class="ri-equalizer-line me-2"></i> Filters
                    </button>
                    <!-- / Filter Trigger-->

                    <!-- Sort Options-->
                    <select class="form-select form-select-sm border-0 bg-light p-3 pe-5 lh-1 fs-7">
                        <option selected>Sort By</option>
                        <option value="1">Hi Low</option>
                        <option value="2">Low Hi</option>
                        <option value="3">Name</option>
                    </select>
                    <!-- / Sort Options-->
                </div> --}}
            </div>
            <!-- /Category Toolbar-->
            <!-- Products-->
            <div class="row g-4">
                @foreach ($product->take(8) as $produk)
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
                                    {{-- <small class="text-muted d-block">{{ implode(' ', array_slice(str_word_count($produk->deskripsi, 1), 0, 6)) }}@if(str_word_count($produk->deskripsi) > 5)...@endif</small> --}}
                                <p class="mt-2 mb-0 small">Rp. {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--/ Card Product-->
            </div>
        </div>
        <!-- /Page Content -->
    </section>
    <!-- / Main Section-->
@endsection
