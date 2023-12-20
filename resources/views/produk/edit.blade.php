@extends('layouts.app')

@section('title', 'Edit Produk')

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
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('produk.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <div class="w-100">
                        <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control mb-2" name="nama" required
                                value="{{ $data->nama }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="w-100">
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10" required>{{ $data->deskripsi }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="w-100">
                        <div class="mb-3">
                            <label>SKU</label>
                            <input type="text" class="form-control mb-2" name="sku" required
                                value="{{ $data->sku }}">
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
                    <label class="form-label" for="specificSizeSelect">Sub Kategori</label>
                    <select style="font-size: 13px" class="form-select" name="subcategory_id" id="subcategory_id">
                        <option selected disabled>pilih subkategori</option>
                        <option selected value="{{ $data->subcategory_id }}">{{ $data->subcategories->nama }}</option>
                        @foreach ($subcategory as $datasubcategory)
                            <option value="{{ $datasubcategory->id }}">{{ $datasubcategory->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <div class="w-100">
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control mb-2" name="stok" required
                                value="{{ $data->stok }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="w-100">
                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" class="form-control mb-2" name="harga" required
                                value="{{ $data->harga }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="w-100">
                        <div class="mb-3">
                            <label>Berat</label>
                            <input type="number" class="form-control mb-2" name="berat" required
                                value="{{ $data->berat }}">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Gambar</label>
                    <img src="uploads/{{ $data->gambar }}" alt="" height="100">
                    <input type="file" class="form-control mb-2" id="gambar" name="gambar">
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
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
