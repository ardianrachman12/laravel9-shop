@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="mx-3">
        @include('layouts.alert')
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('kategori.store') }}" method="post">
                @csrf
                <div>
                    <label>Nama Kategori</label>
                    <input type="text" class="form-control mb-2" name="nama" required>
                </div>
                <div>
                    <label>Deskripsi</label>
                    <textarea class="form-control mb-2" name="deskripsi" id="" cols="30" rows="10" required></textarea>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
