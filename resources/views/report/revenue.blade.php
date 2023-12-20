@extends('layouts.app')
@section('title', 'Reports')

@section('content')
@include('layouts.alert')
    <div class="card shadow">
        <div class="card-header">
            <h4 class="card-title">Revenue</h4>
        </div>
        <div class="card-body">
            <!-- Tampilkan formulir untuk memasukkan rentang tanggal -->
            <form action="{{ route('revenue.report') }}" method="get">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group mb-2">
                                    <span>Start date : </span><input id="startDate" class="form-control datepicker"
                                        type="date" name="start_date" value="{{ $startDate ?? '' }}" required>
                                </div>
                            </td>
                            <td>
                                <div class="form-group mb-2">
                                    <span>End date : </span><input id="endDate" class="form-control datepicker"
                                        type="date" name="end_date" value="{{ $endDate ?? '' }}" required>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mb-4">
                    <button class="btn btn-primary me-2" type="submit">Generate Report</button>
                    <a href="#" id="downloadReportBtn" target="_blank" class="btn btn-primary">Download Report</a>
                    {{-- <a onclick="this.href='/exportPdf/'+ document.getElementById('startDate').value + '/' + document.getElementById('endDate').value"
                        target="_blank" class="btn btn-primary">Download PDF</a> --}}
                    {{-- <a onclick="this.href='/revenuePdf/'+ document.getElementById('startDate').value + '/' + document.getElementById('endDate').value" target="_blank" class="btn btn-primary">Revenue PDF</a> --}}
                </div>
            </form>

            @if (!empty($revenueData))
                <!-- Tampilkan data pendapatan -->
                <table id="myTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Status Payment</th>
                            <th>Order</th>
                            <th>Ongkir</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalHarga = 0;
                            $totalGrandTotal = 0;
                            $totalOngkir = 0;
                        @endphp
                        @foreach ($revenueData as $order)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($order->created_at)->locale('id_ID')->isoFormat('D MMMM Y') }}</td>
                                <td>{{ $order->kode }}</td>
                                <td>{{ $order->payments->first()->status }}</td>
                                <td>Rp. {{ $order->total_harga }}</td>
                                <td>Rp. {{ $order->ongkir }}</td>
                                <td>Rp. {{ $order->grand_total }}</td>
                            </tr>
                            @php
                                $totalHarga += $order->total_harga;
                                $totalGrandTotal += $order->grand_total;
                                $totalOngkir += $order->ongkir;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2">Total:</th>
                            <th></th>
                            <th>Rp. {{ $totalHarga }}</th>
                            <th>Rp. {{ $totalOngkir }}</th>
                            <th>Rp. {{ $totalGrandTotal }}</th>
                        </tr>
                    </tfoot>
                </table>
            @else
                <p>No revenue data available for the selected date range.</p>
            @endif
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.getElementById('downloadReportBtn').addEventListener('click', function(event) {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            // Lakukan validasi di sini
            if (startDate === '' || endDate === '') {
                alert('Please fill in both start date and end date.');
                event.preventDefault(); // Mencegah pengarahan ke tautan jika validasi tidak terpenuhi
            } else {
                // Setel href tautan sesuai dengan nilai startDate dan endDate
                this.href = '/exportPdf/' + startDate + '/' + endDate;
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endpush
