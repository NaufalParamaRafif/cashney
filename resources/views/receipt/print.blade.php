<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi Transaksi #{{ $transaction->code }}</title>
    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
        }
        .text-center { text-align: center; }
        .border-top { border-top: 1px dashed #000; margin: 5px 0; }
        .total { font-weight: bold; font-size: 14px; }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2>PT. Kuat Prima</h2>
        <p>Jl. Ciamis No. 123</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="border-top"></div>

    <p>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
    <p>Kasir: {{ $transaction->cashier_email }}</p>
    @if ($transaction->customer)
        <p>Pelanggan: {{ $transaction->customer->member_code }} ({{ $transaction->customer_email }})</p>
    @endif

    <div class="border-top"></div>

    <table width="100%">
        @foreach ($transaction->transactions_detail as $item)
            <tr>
                <td colspan="2">{{ $item->product_name }}</td>
            </tr>
            <tr>
                <td>{{ $item->product_total }} x Rp {{ number_format($item->price_per_item, 0, ',', '.') }}</td>
                <td align="right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="border-top"></div>

    <p class="total">Total: Rp {{ number_format($transaction->price_total, 0, ',', '.') }}</p>
    @if ($transaction->cashback > 0)
        <p>Cashback: Rp {{ number_format($transaction->cashback, 0, ',', '.') }}</p>
    @endif

    <div class="border-top"></div>

    <div class="text-center">
        <p>Terima kasih telah berbelanja!</p>
    </div>
</body>
</html>
