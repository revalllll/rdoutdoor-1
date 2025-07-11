<?php
// Composer autoload jika belum ada, jalankan: composer require setasign/fpdf
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use FPDF;

class ReportController extends Controller
{
    // Export PDF untuk satu order (resi per order)
    public function exportOrderResi($id)
    {
        try {
            $order = Order::with('orderItems.product')->findOrFail($id);
            $pdf = new \FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(0,10,'INVOICE / RESI ORDER',0,1,'C');
            $pdf->Ln(2);
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(40,8,'Invoice No.',0,0); $pdf->Cell(60,8,$order->order_number,0,0);
            $pdf->Cell(30,8,'Date',0,0); $pdf->Cell(60,8,$order->order_date,0,1);
            $pdf->Cell(40,8,'Customer Name',0,0); $pdf->Cell(60,8,$order->customer_name,0,0);
            $pdf->Cell(30,8,'Address',0,0); $pdf->Cell(60,8,$order->address ?? '-',0,1);
            $pdf->Cell(40,8,'Contact No.',0,0); $pdf->Cell(60,8,$order->phone ?? '-',0,1);
            $pdf->Ln(2);
            // Table header
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(70,8,'Item Description',1);
            $pdf->Cell(25,8,'Quantity',1);
            $pdf->Cell(35,8,'Unit Price',1);
            $pdf->Cell(35,8,'Total',1);
            $pdf->Ln();
            $pdf->SetFont('Arial','',11);
            $subtotal = 0;
            foreach($order->orderItems as $item) {
                $total = $item->price * $item->quantity;
                $pdf->Cell(70,8,$item->product->name,1);
                $pdf->Cell(25,8,$item->quantity,1);
                $pdf->Cell(35,8,'Rp'.number_format($item->price,0,',','.'),1);
                $pdf->Cell(35,8,'Rp'.number_format($total,0,',','.'),1);
                $pdf->Ln();
                $subtotal += $total;
            }
            // Total
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(130,8,'Total Harga (Rp)',1);
            $pdf->Cell(35,8,'Rp'.number_format($subtotal,0,',','.'),1);
            $pdf->Ln(10);
            // Payment info (opsional)
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(65,8,'Payment Method',1);
            $pdf->Ln();
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(65,8,$order->payment_method ?? '-',1);
            header('Content-Type: application/pdf');
            $pdf->Output('I', 'resi_order_'.$order->order_number.'.pdf');
            exit;
        } catch (\Throwable $e) {
            return response($e->getMessage() . '<br><pre>' . $e->getTraceAsString() . '</pre>', 500);
        }
    }

    // Export PDF rekap order dengan filter bulan & tahun
    public function exportOrderPdf(Request $request)
    {
        try {
            $bulan = $request->input('bulan');
            $tahun = $request->input('tahun');
            $query = Order::with('orderItems.product')->where('IsDeleted', 0);
            if ($bulan) {
                $query->whereMonth('order_date', $bulan);
            }
            if ($tahun) {
                $query->whereYear('order_date', $tahun);
            }
            $orders = $query->get();
            $pdf = new \FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',14);
            $judul = 'Laporan Order';
            if ($bulan || $tahun) {
                $judul .= ' Periode ';
                if ($bulan) $judul .= 'Bulan '.str_pad($bulan,2,'0',STR_PAD_LEFT).' ';
                if ($tahun) $judul .= 'Tahun '.$tahun;
            }
            $pdf->Cell(0,10,$judul,0,1,'C');
            $pdf->SetFont('Arial','B',10);
            $pdf->Cell(10,8,'No',1);
            $pdf->Cell(40,8,'Order Number',1);
            $pdf->Cell(35,8,'Customer',1);
            $pdf->Cell(30,8,'Tanggal',1);
            $pdf->Cell(30,8,'Total',1);
            $pdf->Cell(25,8,'Status',1);
            $pdf->Ln();
            $pdf->SetFont('Arial','',10);
            $no = 1;
            foreach($orders as $order) {
                $pdf->Cell(10,8,$no++,1);
                $pdf->Cell(40,8,$order->order_number,1);
                $pdf->Cell(35,8,substr($order->customer_name,0,20),1);
                $pdf->Cell(30,8,$order->order_date,1);
                $pdf->Cell(30,8,'Rp'.number_format($order->total_price,0,',','.'),1);
                $pdf->Cell(25,8,$order->status_label,1);
                $pdf->Ln();
            }
            header('Content-Type: application/pdf');
            $pdf->Output('I', 'laporan_order.pdf');
            exit;
        } catch (\Throwable $e) {
            return response($e->getMessage() . '<br><pre>' . $e->getTraceAsString() . '</pre>', 500);
        }
    }
}
