@extends('layouts.app')

@section('title', 'Data Pembayaran')

@section('content')
@include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Payments Information</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Invoice Code</th>
                            <th>Member Name</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Payment Type</th>
                            <th>VA Number</th>
                            <th>Vendor Name</th>
                            <th>Status</th>
                            <th>Payment date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->orders->kode}}</td>
                                <td>{{ $item->orders->members->nama }}</td>
                                <td>{{ $item->amount }}</td>
                                <td>{{ $item->method }}</td>
                                <td>{{ $item->payment_type }}</td>
                                <td>{{ $item->va_number }}</td>
                                <td>{{ $item->vendor_name }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->created_at }}</td>
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
