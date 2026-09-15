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
        <div class="header" style="background: {{ $status === 'REJECT' ? '#dc2626' : '#d97706' }};">
            <h1>Notifikasi Lot Number - Mechanical Test</h1>
            <span style="display: inline-block; margin-top: 8px; padding: 4px 14px; border-radius: 4px; font-size: 14px; font-weight: 700; background: {{ $status === 'REJECT' ? '#fca5a5' : '#fde68a' }}; color: {{ $status === 'REJECT' ? '#7f1d1d' : '#78350f' }};">
                {{ $status }}
            </span>
        </div>
        <div class="body">
            <p>Berikut adalah detail Lot Number Mechanical Test yang telah diterbitkan:</p>
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
                    <td>Tanggal Inspeksi</td>
                    <td>{{ $tanggal }}</td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>{{ $supplier }}</td>
                </tr>
                <tr>
                    <td>No PO</td>
                    <td>{{ $noPo }}</td>
                </tr>
                <tr>
                    <td>No SJ</td>
                    <td>{{ $noSj }}</td>
                </tr>
                <tr>
                    <td>Jenis Kawat</td>
                    <td>{{ $jenisKawat }}</td>
                </tr>
                <tr>
                    <td>D Kawat</td>
                    <td>{{ $dKawat }} mm</td>
                </tr>
                <tr>
                    <td>No Koil</td>
                    <td>{{ $nomorKoil }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $status }}</td>
                </tr>
                <tr>
                    <td>Hasil Tensile</td>
                    <td>{{ $hasilTensile }} MPa</td>
                </tr>
                <tr>
                    <td>Hasil Coating Weight</td>
                    <td>{{ $hasilCoating }} g/m&sup2;</td>
                </tr>
                <tr>
                    <td>Hasil Lilit</td>
                    <td>{{ $hasilLilit }}</td>
                </tr>
                <tr>
                    <td>Hasil Puntir</td>
                    <td>{{ $hasilPuntir }} kali</td>
                </tr>
                <tr>
                    <td>Description 1</td>
                    <td>{{ $description1 ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Description 2</td>
                    <td>{{ $description2 ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Diinput Oleh</td>
                    <td>{{ $user }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
