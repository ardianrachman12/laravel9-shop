@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
@include('layouts.alert')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Revenue Chart</h4>
        </div>
        <div class="card-body">
            <div id="chart"></div>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4 class="card-title">Product Out of Stock</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="myTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Produk</th>
                            <th>SKU</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->stok }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
        var pendapatan = <?php echo json_encode($total_harga); ?>;
        var bulan = <?php echo json_encode($bulan); ?>;
        Highcharts.chart('chart', {
            title: {
                text: 'Grafik Pendapatan Bulanan'
            },
            xAxis: {
                categories: bulan
            },
            yAxis: {
                title: {
                    text: 'nominal pendapatan bulanan'
                }
            },
            plotOptions: {
                series: {
                    allwoPointSelect: true
                }
            },
            series: [{
                name: 'Nominal pendapatan ',
                data: pendapatan
            }]
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
@endpush
