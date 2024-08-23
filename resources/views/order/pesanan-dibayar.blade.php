@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
    @include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Pesanan dibayar</h4>
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
                                        @if ($item->payments->first()->method == 'midtrans')
                                            <form action="{{ route('confirm', $item->id) }}" method="post"
                                                onsubmit="return confirm('Yakin mau konfirmasi ?')">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm mt-1">confirm</button>
                                            </form>
                                        @endif
                                        <!-- Tombol untuk memunculkan modal -->
                                        @if ($item->payments->first()->method == 'manual')
                                            <button class="btn btn-primary btn-sm mt-1" data-toggle="modal"
                                                data-target="#myModal">Additional Cost</button>
                                        @endif
                                        <form action="{{ route('cancel', $item->id) }}" method="post"
                                            onsubmit="return confirm('Yakin akan dicancel?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm mt-1">cancel</button>
                                        </form>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Additional Cost
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{route("addCost", $item->id)}}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <!-- Formulir Pertama -->
                                                            <div class="form-group">
                                                                <label for="ongkir">Ongkos Kirim:</label>
                                                                <input type="number" class="form-control" id="ongkir"
                                                                    name="ongkir" placeholder="Rp. ">
                                                            </div>
                                                            <!-- Formulir Kedua -->
                                                            <div class="form-group">
                                                                <label for="diskon">Diskon:</label>
                                                                <input type="number" class="form-control" id="diskon"
                                                                    name="diskon" placeholder="Rp. ">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Confirm</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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