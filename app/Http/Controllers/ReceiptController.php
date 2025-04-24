<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class ReceiptController extends Controller
{
    public function print($id)
    {
        $transaction = Transaction::with('transactions_detail.product')->findOrFail($id);
        return view('receipt.print', compact('transaction'));
    }

}
