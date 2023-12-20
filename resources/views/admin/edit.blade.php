@extends('layouts.app')

@section('title', 'edit admin')

@section('content')
    <div class="mx-3">
        @include('layouts.alert')
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.update', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <label>Nama</label>
                    <input type="text" class="form-control mb-2" name="nama" value="{{ $data->name }}">
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" class="form-control mb-2" name="email" value="{{ $data->email }}">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
