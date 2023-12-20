@extends('layouts.app')

@section('title', 'Tambah Slider')

@section('buttons')
    <div class="btn-toolbar mb-2 mb-md-0">
        <div>
            <a href="{{ route('slider.index') }}" class="btn btn-sm btn-light">
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
    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Nama Slider</label>
                    <input type="text" class="form-control mb-2" name="nama" required>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Deskripsi</label>
                    <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10" required></textarea>
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
