@extends('layouts.app')

@push('script')
    <script>
        $(function() {
            $('#category_id').on('change', function() {
                let id_category = $('#category_id').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('produk.select-category') }}",
                    data: {
                        id_category: id_category
                    },
                    cache: false,

                    success: function(msg) {
                        $('#subcategory_id').html(msg);
                    },
                    error: function(data) {
                        console.log('error:', data)
                    },
                })
            })
        })
    </script>
@endpush

@section('title', 'Tambah Produk')

@section('buttons')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div>
            <a href="{{ route('produk.index') }}" class="btn btn-sm btn-light">
                <span class="align-text-center"><i class="fas fa-arrow-left"></i></span>
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="mx-3">
        @include('layouts.alert')
    </div>
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Nama Produk</label>
                    <input type="text" class="form-control mb-2" name="nama" value="{{ old('nama') }}" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10"
                        value="{{ old('deskripsi') }}" required></textarea>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>SKU</label>
                    <input type="text" class="form-control mb-2" name="sku" value="{{ old('sku') }}" required>
                </div>
            </div>
        </div>
        <div class="w-100 mb-3">
            <label class="form-label" for="specificSizeSelect">Kategori</label>
            <select style="font-size: 13px" class="form-select" name="category_id" id="category_id">
                <option selected disabled>pilih kategori</option>
                @foreach ($category as $datacategory)
                    <option value="{{ $datacategory->id }}">{{ $datacategory->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-100 mb-3">
            <label class="form-label" for="specificSizeSelect">Subkategori</label>
            <select style="font-size: 13px" class="form-select" name="subcategory_id" id="subcategory_id">
                <option selected disabled>pilih subkategori</option>
            </select>
        </div>
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Stok</label>
                    <input type="number" class="form-control mb-2" name="stok" value="{{ old('stok') }}" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Berat</label>
                    <input type="number" class="form-control mb-2" name="berat" placeholder="dalam gram"
                        value="{{ old('berat') }}" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Harga</label>
                    <input type="text" class="form-control mb-2" name="harga" value="{{ old('harga') }}" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <label>Gambar</label>
            <input type="file" class="form-control mb-2" id="gambar" name="gambar">
        </div>
        <div class="d-flex justify-content-between align-items-center mb-5">
            <button type="submit" class="btn btn-primary">
                Simpan
            </button>
        </div>
    </form>
@endsection
