@extends('layouts.app')

@section('title', 'Edit Slider')

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
    <form action="{{ route('slider.update', $data->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <div class="w-100">
                <div class="mb-3">
                    <label>Nama Slider</label>
                    <input type="text" class="form-control mb-2" name="nama" required value="{{ $data->nama }}">
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
@endsection
