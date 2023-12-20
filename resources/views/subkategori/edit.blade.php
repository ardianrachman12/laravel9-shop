@extends('layouts.app')

@section('title', 'Edit Sub Kategori')

@section('buttons')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div>
            <a href="{{ route('subkategori.index') }}" class="btn btn-sm btn-light">
                <span class="align-text-center"><i class="fas fa-arrow-left"></i></span>
                Kembali
            </a>
        </div>
    </div>
@endsection

@section('content')
@include('layouts.alert')
    <form action="{{ route('subkategori.update', $data->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Nama Subkategori</label>
                    <input type="text" class="form-control mb-2" name="nama" required value="{{ $data->nama }}">
                </div>
            </div>
            <div class="mb-3">
                <div class="w-100">
                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10" required>{{ $data->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="w-100 mb-3">
                    <label class="form-label" for="specificSizeSelect">Kategori</label>
                    <select style="font-size: 13px" class="form-select form-select-sm" name="category_id" id="category_id">
                        <option selected disabled>pilih kategori</option>
                        <option selected value="{{ $data->category_id }}">{{ $data->categories->nama }}</option>
                        @foreach ($category as $datacategory)
                            <option value="{{ $datacategory->id }}">{{ $datacategory->nama }}</option>
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
