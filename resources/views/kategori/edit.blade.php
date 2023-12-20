@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <div class="mx-3">
        @include('layouts.alert')
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('kategori.update', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <label>Nama Kategori</label>
                    <input type="text" class="form-control mb-2" name="nama" value="{{ $data->nama }}">
                </div>
                <div>
                    <label>Deskripsi</label>
                    <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10">{{ $data->deskripsi }}</textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
