<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice Pesanan #INV{{ $transaksi->id }}</title>
    <style>
        /* Global Styles */
        body { 
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif; 
            color: #333; 
            font-size: 12px; 
            line-height: 1.6; 
            margin: 0; 
            padding: 20px;
        }
        .container { 
            width: 100%; 
            max-width: 800px; /* Optional: limit max width for better readability */
            margin: 0 auto; 
            border: 1px solid #eee; /* Light border around the whole invoice */
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05); /* Soft shadow */
            background: #fff;
        }
        hr { 
            border: none; 
            border-top: 1px solid #eee; 
            margin: 20px 0; 
        }

        /* Header Section */
        .invoice-header { 
            display: table; /* Use table for alignment */
            width: 100%; 
            margin-bottom: 30px;
        }
        .invoice-header > div { 
            display: table-cell; 
            vertical-align: top;
        }
        .invoice-header .logo-info { 
            width: 50%;
        }
        .invoice-header .invoice-info { 
            width: 50%; 
            text-align: right;
        }
        .invoice-header h1 { 
            color: #28a745; /* Green - similar to your primary color */
            margin: 0; 
            font-size: 28px; 
            font-weight: bold;
        }
        .invoice-header .company-name { 
            margin: 5px 0 0 0; 
            font-size: 14px; 
            font-weight: bold; 
            color: #555;
        }
        .invoice-header .invoice-number { 
            font-size: 18px; 
            font-weight: bold; 
            color: #333; 
            margin-bottom: 5px;
        }
        .invoice-header .date-status { 
            font-size: 12px; 
            color: #666; 
            margin-top: 5px;
        }

        /* Customer & Transaction Details */
        .details-section { 
            display: table; 
            width: 100%; 
            margin-bottom: 30px;
        }
        .details-section > div { 
            display: table-cell; 
            vertical-align: top;
            width: 50%;
        }
        .details-section strong { 
            display: block; 
            margin-bottom: 5px; 
            color: #555; 
            font-size: 13px;
        }
        .details-section p { 
            margin: 0; 
            font-size: 12px;
        }

        /* Products Table */
        .table-products { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 30px;
        }
        .table-products th, .table-products td { 
            border: 1px solid #eee; 
            padding: 10px; 
            text-align: left;
            vertical-align: top;
        }
        .table-products th { 
            background-color: #f8f8f8; 
            color: #555; 
            font-weight: bold; 
            text-transform: uppercase;
            font-size: 11px;
        }
        .table-products tbody tr:nth-child(even) { 
            background-color: #fdfdfd; 
        }
        .table-products .text-right { text-align: right; }
        .table-products .text-center { text-align: center; }

        /* Total Section */
        .total-section { 
            margin-top: 30px; 
            width: 100%; 
            display: table;
        }
        .total-row { 
            display: table-row;
        }
        .total-label, .total-value { 
            display: table-cell; 
            padding: 8px 10px; 
            font-size: 13px;
        }
        .total-label { 
            text-align: right; 
            font-weight: bold; 
            width: 70%; 
            color: #555;
        }
        .total-value { 
            text-align: right; 
            width: 30%; 
            font-weight: bold; 
            color: #333;
        }
        .grand-total-row .total-label { 
            font-size: 16px; 
            color: #28a745;
        }
        .grand-total-row .total-value { 
            font-size: 18px; 
            color: #28a745; 
            border-top: 2px solid #28a745; /* Line above total */
            padding-top: 10px;
        }

        /* Notes & Footer */
        .note { 
            margin-top: 40px; 
            font-size: 11px; 
            color: #777; 
            border-top: 1px solid #eee; 
            padding-top: 20px;
        }
        .note p { margin: 0; }
        .footer { 
            text-align: center; 
            margin-top: 30px; 
            font-size: 10px; 
            color: #999; 
            padding-top: 15px; 
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="invoice-header">
        <div class="logo-info">
            <h1>INVOICE</h1>
            <p class="company-name">Marketplace BANGKIT</p>
            <p>Jalan Contoh No. 123, Kota Contoh, 12345</p> {{-- Tambahkan alamat toko --}}
            <p>Email: info@bangkit.com</p> {{-- Tambahkan email toko --}}
        </div>
        <div class="invoice-info">
            <p class="invoice-number">#INV{{ $transaksi->id }}</p>
            <p class="date-status">
                <strong>Tanggal:</strong> {{ $transaksi->created_at->format('d F Y') }}<br>
                <strong>Status:</strong> <span style="color: {{ ($transaksi->status == 'selesai') ? '#28a745' : '#ffc107' }}; font-weight: bold; text-transform: capitalize;">{{ str_replace('_', ' ', $transaksi->status) }}</span>
            </p>
        </div>
    </div>

    <hr>

    <div class="details-section">
        <div>
            <strong>Ditagihkan Kepada:</strong>
            <p>{{ $transaksi->user->nama ?? 'N/A' }}</p>
            <p>{{ $transaksi->user->email ?? 'N/A' }}</p> {{-- Tambah email pembeli --}}
        </div>
        <div>
            <strong>Alamat Pengiriman:</strong>
            <p>{{ $transaksi->alamat_pengiriman }}</p>
            {{-- <p>Nomor Telepon: {{ $transaksi->user->telepon ?? 'N/A' }}</p> --}} {{-- Tambah nomor telepon jika ada --}}
        </div>
    </div>

    <table class="table-products">
        <thead>
            <tr>
                <th>Produk</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi->details as $detail)
                <tr>
                    <td>{{ $detail->produk->nama ?? 'Produk Dihapus' }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $detail->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <div class="total-label">Subtotal Produk</div>
            <div class="total-value">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div> {{-- Jika total_harga hanya produk, atau buat subtotal terpisah --}}
        </div>
        {{-- Jika ada ongkir atau pajak, tambahkan di sini --}}
        {{-- <div class="total-row">
            <div class="total-label">Ongkos Kirim</div>
            <div class="total-value">Rp {{ number_format($transaksi->ongkir ?? 0, 0, ',', '.') }}</div>
        </div> --}}
        <div class="total-row grand-total-row">
            <div class="total-label">TOTAL PEMBAYARAN</div>
            <div class="total-value">Rp {{ number_format($transaksi->total_harga + ($transaksi->ongkir ?? 0), 0, ',', '.') }}</div> {{-- Sesuaikan jika ada ongkir --}}
        </div>
    </div>

    <div class="note">
        <p>Terima kasih telah berbelanja di Marketplace BANGKIT. Invoice ini adalah bukti transaksi yang sah.</p>
        <p>Untuk pertanyaan atau bantuan, silakan hubungi kami di info@bangkit.com.</p>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Marketplace BANGKIT. Semua hak dilindungi.
    </div>
</div>
</body>
</html>