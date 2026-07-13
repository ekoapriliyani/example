<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #dc2626;
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
        }

        .body {
            background: #f9fafb;
            padding: 20px;
            border: 1px solid #e5e7eb;
        }

        .label {
            font-weight: 700;
            color: #374151;
        }

        .value {
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        td:first-child {
            width: 40%;
            font-weight: 700;
            color: #374151;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Notifikasi Lot Number {{ $status }}</h1>
        </div>
        <div class="body">
            <p>Berikut adalah detail Lot Number yang telah diterbitkan:</p>
            <table>
                <tr>
                    <td>Lot Number</td>
                    <td>{{ $lotNumber }}</td>
                </tr>
                <tr>
                    <td>Nomor Inspeksi</td>
                    <td>{{ $nomorInspeksi }}</td>
                </tr>
                <tr>
                    <td>PRO ID</td>
                    <td>{{ $proId }}</td>
                </tr>
                <tr>
                    <td>Description Barang</td>
                    <td>{{ $description ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Nama Mesin</td>
                    <td>{{ $namaMesin ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $status }}</td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td>{{ $qty }}</td>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td>{{ $weight ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tanggal Inspeksi</td>
                    <td>{{ $tanggal }}</td>
                </tr>
                <tr>
                    <td>Diinput Oleh</td>
                    <td>{{ $user }}</td>
                </tr>
                <tr>
                    <td colspan="2" style="padding-top: 16px; font-weight: 700; color: #374151;">Detail Inspeksi</td>
                </tr>
                @forelse ($details as $detail)
                    <tr>
                        <td style="padding-left: 12px;">{{ $detail->description }}</td>
                        <td>{{ $detail->description2 }}{{ $detail->qty ? ' (' . $detail->qty . ')' : '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td style="padding-left: 12px; color: #9ca3af;" colspan="2">Tidak ada detail</td>
                    </tr>
                @endforelse
            </table>
        </div>
    </div>
</body>

</html>
