<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan #INV{{ $transaksi->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif; color: #333; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .header h1 { color: #10B981; margin: 0; font-size: 24px; }
        .header p { margin: 0; }
        table { width: 100%; border-collapse: collapse; }
        .invoice-details table td { padding: 5px 0; }
        .invoice-details .right { text-align: right; }
        .table-products { margin-top: 30px; }
        .table-products th, .table-products td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table-products th { background-color: #f2f2f2; }
        .total-section { margin-top: 20px; text-align: right; }
        .total-section .total-amount { font-size: 18px; font-weight: bold; color: #10B981; }
        .footer { text-align: center; margin-top: 50px; font-size: 10px; color: #777; }
    </style>
</head>
<body>
<div class="container">
    <table class="header-table">
        <tr>
            <td>
                <h1 style="color: #10B981;">INVOICE</h1>
                <p><strong>Marketplace BANGKIT</strong></p>
            </td>
            <td style="text-align: right;">
                <p>#INV{{ $transaksi->id }}</p>
            </td>
        </tr>
    </table>
    <hr>
    <div class="invoice-details">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>Ditagihkan Kepada:</strong><br>
                    {{ $transaksi->user->nama ?? 'N/A' }}<br>
                    {{ $transaksi->alamat_pengiriman }}
                </td>
                <td class="right" style="width: 50%;">
                    <strong>Tanggal Invoice:</strong> {{ $transaksi->created_at->format('d M Y') }}<br>
                    <strong>Status Pembayaran:</strong> Lunas
                </td>
            </tr>
        </table>
    </div>

    <table class="table-products">
        <thead>
            <tr>
                <th>Produk</th>
                <th style="text-align: right;">Harga Satuan</th>
                <th style="text-align: center;">Jumlah</th>
                <th style="text-align: right;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
                <tr>
                    <td>{{ $detail->produk->nama ?? 'Produk Dihapus' }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga,0,',','.') }}</td>
                    <td style="text-align: center;">{{ $detail->jumlah }}</td>
                    <td style="text-align: right;">Rp {{ number_format($detail->harga * $detail->jumlah,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold; border: none; padding: 10px;">Total Bayar</td>
                <td style="text-align: right; font-weight: bold; border: 1px solid #ddd; padding: 10px;">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="note" style="margin-top: 30px; font-size: 11px; color: #777;">
        <p>Terima kasih telah berbelanja di Marketplace BANGKIT. Invoice ini adalah bukti pembayaran yang sah.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Marketplace BANGKIT.
    </div>
</div>
</body>
</html>