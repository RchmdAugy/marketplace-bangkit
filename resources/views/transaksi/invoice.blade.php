<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan</title>
    <style>
        body { font-family: sans-serif; }
        h2 { text-align:center; }
        table { width: 100%; border-collapse: collapse; margin-top:20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        footer { text-align: center; margin-top: 50px; font-size: 12px; }
    </style>
</head>
<body>

<h2>INVOICE PESANAN<br>Marketplace BANGKIT</h2>

<table>
    <tr><th>No Invoice</th><td>#INV{{ $transaksi->id }}</td></tr>
    <tr><th>Tanggal</th><td>{{ $transaksi->created_at->format('d-m-Y') }}</td></tr>
    <tr><th>Nama Pembeli</th><td>{{ $transaksi->user->nama }}</td></tr>
    <tr><th>Produk</th><td>{{ $transaksi->produk->nama }}</td></tr>
    <tr><th>Jumlah</th><td>{{ $transaksi->jumlah }}</td></tr>
    <tr><th>Total Harga</th><td>Rp {{ number_format($transaksi->total_harga,0,',','.') }}</td></tr>
    <tr><th>Status</th><td>{{ ucfirst($transaksi->status) }}</td></tr>
</table>

<footer>
    &copy; {{ date('Y') }} Marketplace BANGKIT - Invoice Pesanan
</footer>

</body>
</html>
