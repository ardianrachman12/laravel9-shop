@extends('layouts.app')

@section('title', 'Product')

@section('content')
@include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Data Produk</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <a href="{{ route('produk.create') }}" class="btn btn-primary mb-3">Tambah data</a>
            </div>
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>SKU</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Stok</th>
                            <th>Berat</th>
                            <th>Harga</th>
                            <th>Subkategori</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td><img src="uploads/{{ $item->gambar }}" alt="" height="100"></td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->berat }} gr.</td>
                                <td>Rp. {{ $item->harga }}</td>
                                <td>{{ $item->subcategories->nama }}</td>
                                <td>
                                    <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-warning btn-sm">edit</a>
                                    <form action="{{ route('produk.destroy', $item->id) }}" type="button" method="post"
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
            {{-- <div class="mt-2">
                <button type="button" class="btn btn-success rounded me-2" data-toggle="modal"
                    data-target="#uploadModal">Upload</button>
            </div> --}}
            <!-- Modal untuk mengunggah file -->
            <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Unggah File</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('uploadProduct')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="inputGroupFile01"><span
                                            data-feather="file-plus"></span></label>
                                    <input type="file" class="form-control" id="inputGroupFile01" name="file_product">
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
