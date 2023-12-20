@extends('layouts.app')

@section('title', 'Tambah Sub Kategori')

@section('content')
@include('layouts.alert')
    <form action="{{ route('subkategori.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Nama Subkategori</label>
                    <input type="text" class="form-control mb-2" name="nama" required>
                </div>
            </div>
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10" required></textarea>
                    </div>
                </div>
                <div class="w-100 mb-3">
                    <label class="form-label" for="specificSizeSelect">Kategori</label>
                    <select style="font-size: 13px" class="form-select form-select-sm" name="category_id" id="category_id">
                        <option selected disabled>pilih kategori</option>
                        @foreach ($category as $data)
                            <option value="{{ $data->id }}">{{ $data->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-5">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection
