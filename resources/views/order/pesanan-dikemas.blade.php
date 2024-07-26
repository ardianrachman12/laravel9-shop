@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
@include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Pesanan dikemas</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Invoice</th>
                            <th>Nama Pembeli</th>
                            <th>Status Pembayaran</th>
                            <th>Tanggal Order</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->kode }}</td>
                                <td>{{ $item->users->name }}</td>
                                <td>{{ $item->payments->first()->status }}</td>
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <div class="d-grid col-6">
                                        <a href="{{ route('detailpesanan', $item->id) }}"
                                            class="btn btn-warning btn-sm">view</a>
                                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"
                                            class="btn btn-primary btn-sm mt-1">Input Resi</button>
                                        <form action="{{ route('cancel', $item->id) }}" method="post"
                                            onsubmit="return confirm('Yakin akan dicancel?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm mt-1">cancel</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            {{-- modal input resi --}}
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Input Resi</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('inputresi', $item->id) }}" method="post">
                                            @csrf
                                            <div class="modal-body">
                                                <input name="resi" type="text" class="form-control"
                                                    placeholder="input resi">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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