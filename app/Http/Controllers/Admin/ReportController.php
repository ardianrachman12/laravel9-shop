<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RevenueExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function revenue(Request $request, RevenueExport $export)
    {
        // Validasi input
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Tentukan rentang tanggal default jika input kosong
        $startDate = $request->filled('start_date') ? $request->input('start_date') : now()->startOfMonth()->toDateString();
        $endDate = $request->filled('end_date') ? $request->input('end_date') : now()->endOfMonth()->toDateString();


        // Ambil data dari database berdasarkan rentang tanggal
        $revenueData = Order::with('payments')->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '=', 4) // Sesuaikan dengan status pesanan yang menunjukkan selesai
            ->get();

        foreach ($revenueData as $order) {
            $order->status_pembayaran = $order->status_pembayaran == 1 ? 'PAID' : 'UNPAID';
        }

        // Set tanggal pada objek export
        // $export->getStartDate($this->startDate);
        // $export->getEndDate($this->endDate);

        // dd($export);


        // Kirim data ke tampilan
        return view('report.revenue', compact('revenueData', 'export', 'startDate', 'endDate'));
    }

    // public function revenuePdf($startDate, $endDate)
    // {
    //     $order = Order::with('payments')->whereBetween('created_at', [$startDate, $endDate])
    //         ->where('status', '=', 3) // Sesuaikan dengan status pesanan yang menunjukkan selesai
    //         ->get();

    //     return view('report.pdf.revenue-pdf', compact('order', 'startDate', 'endDate'));
    // }

    public function exportPdf($startDate, $endDate)
    {
        $order = Order::with('payments')->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '=', 4) // Sesuaikan dengan status pesanan yang menunjukkan selesai
            ->get();

        $pdf = Pdf::loadView('report.pdf.revenue-pdf', ['order' => $order, 'startDate' => $startDate, 'endDate' => $endDate]);
        return $pdf->download('report.pdf');
    }


    // public function generateReport($startDate, $endDate)
    // {
    //     // dd($startDate, $endDate);
    //     $export = new RevenueExport;
    //     $export->setStartDate($startDate);
    //     $export->setEndDate($endDate);

    //     // dd($export);

    //     return Excel::download($export, 'revenue_report.xlsx');
    // }

    // public function exportExcel()
    // {
    //     return Excel::download(new RevenueExport(), 'revenue_report.xlsx');
    // }
}
