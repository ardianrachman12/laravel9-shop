@extends('layouts.home.app-home')
@section('content')
    <section class="container-fluid mb-4">
        @include('layouts.alert')
    </section>
    <section class="mt-2">
        <div class="container-fluid" data-aos="fade-in">
            <!-- Category Toolbar-->
            <div class="d-flex justify-content-between items-center pt-2 pb-4 flex-column flex-lg-row">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">{{ $subcategory->categories->nama }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $subcategory->nama }}</li>
                        </ol>
                    </nav>
                    <h1 class="fw-bold fs-3 mb-2">{{ $subcategory->nama }}</h1>
                    <p class="m-0 text-muted small">Showing {{ $subcategory->products->count() }} of
                        {{ $subcategory->products->count() }}</p>
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
                                <a class="text-decoration-none link-cover"
                                    href="{{ route('home.product-detail', ['id' => $produk->id]) }}">{{ $produk->nama }}</a>
                                {{-- <small class="text-muted d-block">{{ $produk->deskripsi }}</small> --}}
                                <p class="mt-2 mb-0 small"><span
                                        class="text">Rp.{{ number_format($produk->harga, 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!--/ Card Product-->
                <!-- / Products-->
            </div>
        </div>
        <!-- /Page Content -->
        <div class="d-flex justify-content-center align-items-center py-4">
            {{ $product->links() }}
        </div>
    </section>
@endsection
