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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            width: 100mm;
            height: 50mm;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            align-items: center;
            gap: 6mm;
            padding: 3mm;
        }
        .qr-code svg {
            width: 42mm;
            height: 42mm;
            display: block;
        }
        .caption {
            font-size: 9pt;
            line-height: 1.5;
        }
        .caption .lot {
            font-size: 11pt;
            font-weight: 700;
            margin-bottom: 2mm;
        }
        .caption .row {
            margin-bottom: 1mm;
        }
        .caption .label {
            font-weight: 600;
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
        <div class="qr-code">{!! $qrSvg !!}</div>
        <div class="caption">
            <div class="lot">{{ $fg->lot_number }}</div>
            <div class="row"><span class="label">No. Inspeksi:</span> {{ $inspeksiWm->nomor_inspeksi }}</div>
            <div class="row"><span class="label">No. PRO:</span> {{ $pro->pro_id }}</div>
        </div>
    </div>
    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
