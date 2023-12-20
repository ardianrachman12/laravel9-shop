@extends('layouts.app')

@section('title', 'Data Admin')
@section('content')
    @include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py3">
            <h4 class="card-title">Data Admin</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Tambah data</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <a href="{{ route('admin.edit', $item->id) }}" class="btn btn-warning btn-sm">edit</a>
                                    <form action="" method="post" onsubmit="return confirm('Yakin akan dicancel?')">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm mt-1">hapus</button>
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
