@extends('layouts.app')

@section('title', 'Tambah Admin')

@section('content')
    <div class="mx-3">
        @include('layouts.alert')
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('admin.store') }}" method="post">
                @csrf
                <div>
                    <label>Nama</label>
                    <input type="text" class="form-control mb-2" name="name">
                </div>
                <div>
                    <label>Email</label>
                    <input type="email" class="form-control mb-2" name="email">
                </div>
                <div>
                    <label>No HP</label>
                    <input type="text" class="form-control mb-2" name="no_hp">
                </div>
                <div>
                    <label>Password</label>
                    <input type="text" class="form-control mb-2" name="password">
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
