@extends('layouts.app')

@section('title', 'Data Member')

@section('content')
@include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Data Member</h4>
        </div>
        <div class="card-body">
            {{-- <div class="d-flex justify-content-end">
                <a href="" class="btn btn-primary mb-3">Tambah data</a>
            </div> --}}
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>name</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->no_hp }}</td>
                                <td>
                                    {{-- <a href="" class="btn btn-warning btn-sm">edit</a> --}}
                                    <form action="{{ route('member.destroy', $item->id) }}" type="button" method="post"
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
