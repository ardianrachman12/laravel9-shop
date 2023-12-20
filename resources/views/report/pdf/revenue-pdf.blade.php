<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px;
        }
        .header img {
            width: 100px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Revenue Report</h2>
        <h5>{{ $startDate }} hingga {{ $endDate }}</h5>
    </div>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Order ID</th>
                <th>Status Payment</th>
                <th>Order</th>
                <th>Total Amount</th>
                <!-- Sesuaikan dengan kolom data lainnya -->
            </tr>
        </thead>
        <tbody>
            @php
                $totalHarga = 0;
                $totalGrandTotal = 0;
            @endphp
            @foreach ($order as $order)
                <tr>
                    <td>{{ $order->created_at->formatLocalized('%d %B %Y') }}</td>
                    <td>{{ $order->kode }}</td>
                    <td>{{ $order->payments->first()->status }}</td>
                    <td>Rp. {{ $order->total_harga }}</td>
                    <td>Rp. {{ $order->grand_total }}</td>
                    <!-- Sesuaikan dengan kolom data lainnya -->
                </tr>
                @php
                    $totalHarga += $order->total_harga;
                    $totalGrandTotal += $order->grand_total;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="2">Total:</th>
                <th></th>
                <th>Rp. {{ $totalHarga }}</th>
                <th>Rp. {{ $totalGrandTotal }}</th>
                <!-- Sesuaikan dengan kolom data lainnya -->
            </tr>
        </tfoot>
    </table>
</body>

</html>
