@extends('layouts.app')

@section('title', 'Data Pesanan')

@section('content')
@include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Pesanan dibatalkan</h4>
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
                                @if ($item->status_pembayaran == 0)
                                    @php
                                        $item->status_pembayaran = 'UNPAID';
                                    @endphp
                                    <td>{{ $item->status_pembayaran }}</td>
                                @else
                                    <td>{{ $item->payments->first()->status }}</td>
                                @endif
                                <td>{{ $item->created_at }}</td>
                                <td>
                                    <div class="d-grid col-6">
                                        <a href="{{route('detailpesanan',$item->id)}}" class="btn btn-warning btn-sm">view</a>
                                        {{-- <form action="{{route('confirm',$item->id)}}" method="post"onsubmit="return confirm('Yakin mau konfirmasi ?')">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm mt-1">confirm</button>
                                        </form>
                                        <form action="" method="post"
                                            onsubmit="return confirm('Yakin akan dihapus?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm mt-1">cancel</button>
                                        </form> --}}
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