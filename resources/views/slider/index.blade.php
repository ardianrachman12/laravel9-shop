@extends('layouts.app')

@section('title', 'Slider')

@section('content')
    @include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Data Slider</h4>
                <a href="{{ route('slider.create') }}" class="btn btn-primary">Tambah data</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td><img src="uploads/{{ $item->gambar }}" alt="" height="100"></td>
                                <td>
                                    <a href="{{ route('slider.edit', $item->id) }}" class="btn btn-warning btn-sm">edit</a>
                                    <form action="{{ route('slider.destroy', $item->id) }}" type="button" method="post"
                                        onsubmit="return confirm('Yakin akan dihapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm mt-1">hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endpush
