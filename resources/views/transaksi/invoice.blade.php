<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan #INV{{ $transaksi->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .header,
        .footer {
            text-align: center;
            margin-bottom: 30px;
            color: #1abc9c; /* Primary color */
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 28px;
            font-weight: bold;
            color: #1abc9c; /* Primary color */
        }
        .header p {
            font-size: 16px;
            margin: 5px 0;
        }
        .invoice-details {
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-details table td {
            padding: 5px 0;
            vertical-align: top;
        }
        .invoice-details table td.right {
            text-align: right;
        }
        .table-products {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table-products th,
        .table-products td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table-products th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-section {
            border-top: 2px solid #1abc9c; /* Primary color */
            padding-top: 10px;
            margin-top: 20px;
            text-align: right;
            font-size: 16px;
        }
        .total-section .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #28a745; /* Success color */
        }
        .note {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        .customer-info strong {
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>INVOICE PESANAN</h1>
        <p>Marketplace BANGKIT</p>
    </div>

    <div class="invoice-details">
        <table>
            <tr>
                <td>
                    <strong>No Invoice:</strong> #INV{{ $transaksi->id }}<br>
                    <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d-m-Y H:i') }}<br>
                    <strong>Status:</strong> <span style="color:{{ $transaksi->status == 'selesai' ? '#28a745' : ($transaksi->status == 'dikirim' ? '#17a2b8' : ($transaksi->status == 'diproses' ? '#ffc107' : '#6c757d')) }}; font-weight: bold;">{{ ucfirst($transaksi->status) }}</span>
                </td>
                <td class="right">
                    <strong>Pembeli:</strong> {{ $transaksi->user->nama ?? 'N/A' }}<br>
                    <strong>Email:</strong> {{ $transaksi->user->email ?? 'N/A' }}<br>
                    <strong>Alamat Pengiriman:</strong> {{ $transaksi->alamat_pengiriman }}
                </td>
            </tr>
        </table>
    </div>

    <table class="table-products">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
                <tr>
                    <td>{{ $detail->produk->nama ?? 'Produk Dihapus' }}</td>
                    <td>Rp {{ number_format($detail->harga,0,',','.') }}</td>
                    <td>{{ $detail->jumlah }}</td>
                    <td>Rp {{ number_format($detail->harga * $detail->jumlah,0,',','.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        Total Bayar: <span class="total-amount">Rp {{ number_format($transaksi->total_harga,0,',','.') }}</span>
    </div>

    <div class="note">
        Terima kasih atas pesanan Anda di Marketplace BANGKIT. Pembayaran telah dikonfirmasi.
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Marketplace BANGKIT.
    </div>
</div>

</body>
</html>
