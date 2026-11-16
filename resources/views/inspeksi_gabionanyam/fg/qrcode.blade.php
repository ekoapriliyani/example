<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code - {{ $fg->lot_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            width: 100mm;
            height: 50mm;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @page {
            size: 100mm 50mm;
            margin: 0;
        }

        @media print {
            body {
                width: 100mm;
                height: 50mm;
            }
        }

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4mm;
            padding: 2mm 3mm;
            width: 100%;
            height: 100%;
        }

        .qr-wrapper {
            flex-shrink: 0;
        }

        .qr-wrapper svg {
            width: 46mm;
            height: 46mm;
        }

        .info {
            flex: 1;
            min-width: 0;
        }

        .info table {
            font-size: 7.5pt;
            line-height: 1.3;
            border-collapse: collapse;
        }

        .info table td {
            padding: 0.3mm 1mm;
            vertical-align: top;
        }

        .info table td:first-child {
            font-weight: bold;
            white-space: nowrap;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container">
        <div class="qr-wrapper">
            {!! $qrSvg !!}
        </div>
        <div class="info">
            <table>
                <tr>
                    <td>Lot Number</td>
                    <td>: {{ $fg->lot_number }}</td>
                </tr>
                <tr>
                    <td>Nomor Inspeksi</td>
                    <td>: {{ $inspeksiGabionanyam->nomor_inspeksi }}</td>
                </tr>
                <tr>
                    <td>PRO ID</td>
                    <td>: {{ $pro->pro_id }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>: <span id="desc-caption">{{ $pro->description ?? '-' }}</span></td>
                </tr>
                <tr>
                    <td>Nama Mesin</td>
                    <td>: {{ $inspeksiGabionanyam->mesin->nama_mesin ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Shift</td>
                    <td>: {{ $inspeksiGabionanyam->shift ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: {{ $fg->status }}</td>
                </tr>
                <tr>
                    <td>Quantity</td>
                    <td>: {{ $fg->qty }}</td>
                </tr>
                <tr>
                    <td>Weight</td>
                    <td>: {{ $fg->weight ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: {{ $inspeksiGabionanyam->tanggal }}</td>
                </tr>
                <tr>
                    <td>Inspector</td>
                    <td>: {{ $fg->user->name ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 0 3mm 1mm 3mm; font-size: 6pt;">
        <div style="font-weight: bold; margin-bottom: 0.5mm;">Detail Inspeksi:</div>
        <table style="width: 100%; border-collapse: collapse; font-size: 6pt;">
            <tbody>
                @forelse ($fg->details as $detail)
                    <tr>
                        <td style="padding: 0.3mm 0.5mm; vertical-align: top;">{{ $detail->description }}</td>
                        <td style="padding: 0.3mm 0.5mm; vertical-align: top; white-space: nowrap;">{{ $detail->description2 }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="padding: 0.3mm 0.5mm; font-style: italic; color: #999;">-</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script>
        function zoomCaptionToFit() {
            const caption = document.getElementById('desc-caption');
            if (!caption) return;

            const cell = caption.parentElement;
            const maxWidth = cell.clientWidth;
            let fontSize = parseFloat(window.getComputedStyle(caption).fontSize);

            while (caption.scrollWidth > maxWidth && fontSize > 4) {
                fontSize -= 0.25;
                caption.style.fontSize = fontSize + 'pt';
            }
        }

        window.addEventListener('load', zoomCaptionToFit);
    </script>
</body>

</html>
