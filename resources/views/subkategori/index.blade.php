@extends('layouts.app')

@section('title', 'Subkategori')

@section('content')
    @include('layouts.alert')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between">
                <h4 class="card-title">Data Subkategori</h4>
                <a href="{{ route('subkategori.create') }}" class="btn btn-primary">Tambah data</a>
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
                            <th>kategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->categories->nama }}</td>
                                <td>
                                    <a href="{{ route('subkategori.edit', $item->id) }}"
                                        class="btn btn-warning btn-sm">edit</a>
                                    <form action="{{ route('subkategori.destroy', $item->id) }}" type="button"
                                        method="post" onsubmit="return confirm('Yakin akan dihapus?')">
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
            <div class="mt-2">
                <button type="button" class="btn btn-success rounded me-2" data-toggle="modal"
                    data-target="#uploadModal">Upload</button>
            </div>
            <!-- Modal untuk mengunggah file -->
            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Unggah File</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('uploadSubcategory') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupFile01"><span
                                            data-feather="file-plus"></span></label>
                                    <input type="file" class="form-control" id="inputGroupFile01"
                                        name="file_subcategory">
                                </div>
                                <button type="submit" class="btn btn-primary">Unggah</button>
                            </form>
                        </div>
                    </div>
                </div>
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
