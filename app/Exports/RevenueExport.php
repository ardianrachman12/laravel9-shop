<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RevenueExport implements FromCollection, WithHeadings, WithMapping
{
    public $startDate;
    public $endDate;

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function collection()
    {
        $orders = Order::with('payments', 'members')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();
        // Calculate totals
        $totalHarga = $orders->sum('total_harga');
        $totalGrandTotal = $orders->sum('grand_total');
        $totalOngkir = $orders->sum('ongkir');

        // Add a new row with the totals
        // Tambahkan baris total
        $totalsRow = new Collection([
            'Total',
            '', // Order ID
            '', // Member ID
            '', // Status Order
            '', // Kode Invoice
            $totalHarga,
            $totalOngkir,
            $totalGrandTotal,
            '', // Status Payment
        ]);

        // Concatenate the totals row with the existing orders
        $orders = $orders->concat([$totalsRow]);

        return $orders;
    }

    public function map($row): array
    {
        if ($row instanceof Order) {
            return [
                $row->created_at,
                $row->id,
                $row->members->nama,
                $row->status,
                $row->kode,
                $row->total_harga,
                $row->ongkir,
                $row->grand_total,
                optional($row->payments->first())->status,
            ];
        } else {
            // Handle the case where $row is not an instance of Order
            // You can return an array with appropriate values or handle it based on your requirement
            return [];
        }
    }

    public function headings(): array
    {
        return [
            'Date',
            'Order ID',
            'Member ID',
            'Status Order',
            'Kode Invoice',
            'Total Harga',
            'Ongkir',
            'Grand Total',
            'Status Payment',
        ];
    }
}
