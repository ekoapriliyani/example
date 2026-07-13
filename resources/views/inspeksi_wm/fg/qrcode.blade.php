<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>QR Code - {{ $fg->lot_number }}</title>
    <style>
        @page { size: 100mm 50mm; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            width: 100mm; height: 50mm;
            display: flex; align-items: center;
            font-family: Arial, sans-serif;
            font-size: 7pt; line-height: 1.3;
            padding: 2mm 3mm;
        }
        .container { display: flex; align-items: center; gap: 3mm; width: 100%; }
        .qr-code svg { width: 28mm; height: 28mm; display: block; flex-shrink: 0; }
        .caption { flex: 1; min-width: 0; }
        .lot { font-size: 9pt; font-weight: 700; margin-bottom: 0.5mm; }
        .row { margin-bottom: 0.3mm; }
        .label { font-weight: 600; }
        .alasan { margin-top: 0.5mm; }
        .alasan-title { font-weight: 600; }
        .alasan-item { padding-left: 2mm; }
        @media screen {
            body { margin: 20px auto; border: 1px dashed #ccc; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="qr-code">{!! $qrSvg !!}</div>
        <div class="caption">
            <div class="lot">{{ $fg->lot_number }}</div>
            <div class="row"><span class="label">No:</span> {{ $inspeksiWm->nomor_inspeksi }}</div>
            <div class="row"><span class="label">PRO:</span> {{ $pro->pro_id }}</div>
            <div class="row"><span class="label">Desc:</span> {{ $pro->description }}</div>
            <div class="row"><span class="label">Qty:</span> {{ $fg->qty }} | <span class="label">W:</span> {{ $fg->weight }} Kg</div>
            @if ($fg->details->isNotEmpty())
                <div class="alasan">
                    <div class="alasan-title">Alasan:</div>
                    @foreach ($fg->details as $detail)
                        <div class="alasan-item">• {{ $detail->description }}{{ $detail->description2 ? ' — ' . $detail->description2 : '' }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <script>window.onload=function(){window.print();}</script>
</body>
</html>
