<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Http\Request;

class TransactionExportController extends Controller
{
    public function export()
    {
        // Ambil data transaksi beserta transaksi detail
        $transactions = Transaction::with('transactions_detail.product')->get();

        // Buat objek Spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Menambahkan header
        $sheet->setCellValue('A1', 'Kode Transaksi');
        $sheet->setCellValue('B1', 'Tanggal');
        $sheet->setCellValue('C1', 'Pelanggan');
        $sheet->setCellValue('D1', 'Total');
        $sheet->setCellValue('E1', 'Produk');

        // Loop melalui transaksi dan masukkan ke spreadsheet
        $row = 2;
        foreach ($transactions as $transaction) {
            $sheet->setCellValue('A' . $row, $transaction->code);
            $sheet->setCellValue('B' . $row, $transaction->created_at->format('Y-m-d H:i'));
            $sheet->setCellValue('C' . $row, $transaction->customer_email ?? '-');
            $sheet->setCellValue('D' . $row, $transaction->total);
            $sheet->setCellValue('E' . $row, $transaction->transactions_detail->map(function ($detail) {
                return $detail->product->name . ' ×' . $detail->quantity;
            })->implode(', '));
            $row++;
        }

        // Siapkan writer untuk menyimpan file
        $writer = new Xlsx($spreadsheet);
        $filename = 'transactions.xlsx';

        // Mengirimkan file Excel ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
