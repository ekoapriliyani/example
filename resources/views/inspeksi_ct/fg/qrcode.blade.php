<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>QR Code - {{ $fg->lot_number }}</title>
    <style>
        @page {
            size: 100mm 50mm;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            width: 100mm;
            height: 50mm;
            display: flex;
            align-items: center;
            font-family: Arial, sans-serif;
            font-size: 7pt;
            line-height: 1.3;
            padding: 2mm 3mm;
        }

        .container {
            display: flex;
            align-items: center;
            gap: 3mm;
            width: 100%;
        }

        .qr-code svg {
            width: 28mm;
            height: 28mm;
            display: block;
            flex-shrink: 0;
        }

        .caption {
            flex: 1;
            min-width: 0;
        }

        .lot {
            font-size: 9pt;
            font-weight: 700;
            margin-bottom: 0.5mm;
        }

        .row {
            margin-bottom: 0.3mm;
        }

        .label {
            font-weight: 600;
        }

        /* Penambahan CSS untuk membuat nilai tabel tebal/bold */
        .value {
            font-weight: bold;
            /* atau font-weight: 700; */
        }

        .alasan {
            margin-top: 0.5mm;
        }

        .alasan-title {
            font-weight: 600;
        }

        .alasan-item {
            padding-left: 2mm;
            font-weight: bold;
            /* Ditambahkan juga jika ingin detail inspeksi ikut cetak tebal */
        }

        @media screen {
            body {
                margin: 20px auto;
                border: 1px dashed #ccc;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="qr-code">
            {!! $qrSvg !!}
        </div>
        <div class="caption">
            <table class="info-table">
                <tr>
                    <td class="">Lot Number</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $fg->lot_number }}</td>
                </tr>
                <tr>
                    <td class="">Nomor Inspeksi</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $inspeksiCt->nomor_inspeksi }}</td>
                </tr>
                <tr>
                    <td class="">PRO ID</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pro->pro_id }}</td>
                </tr>
                <tr>
                    <td class="">Description Barang</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $pro->description }}</td>
                </tr>
                <tr>
                    <td class="">Nama Mesin</td>
                    <td class="separator">:</td>
                    <td class="value">
                        {{ $inspeksiCt->mesin->mesin_id }}
                    </td>
                </tr>
                <tr>
                    <td class="">Shift</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $inspeksiCt->shift }}</td>
                </tr>
                <tr>
                    <td class="">Status</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $fg->status }}</td>
                </tr>
                <tr>
                    <td class="">Quantity</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $fg->qty }}</td>
                </tr>
                <tr>
                    <td class="">Weight</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $fg->weight }} Kg</td>
                </tr>
                <tr>
                    <td class="">Tanggal</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $inspeksiCt->tanggal }}</td>
                </tr>
                <tr>
                    <td class="">Inspector</td>
                    <td class="separator">:</td>
                    <td class="value">{{ $fg->user->name }}</td>
                </tr>
            </table>

            @if ($fg->details->isNotEmpty())
                <div class="alasan">
                    <div class="">Detail Inspeksi :</div>
                    @foreach ($fg->details as $detail)
                        <div class="alasan-item">
                            {{ $detail->description }}{{ $detail->description2 ? ' — ' . $detail->description2 : '' }}
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
