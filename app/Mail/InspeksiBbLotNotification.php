<?php

namespace App\Mail;

use App\Models\IncomingBahanBakuInspeksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InspeksiBbLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IncomingBahanBakuInspeksi $inspeksi,
    ) {}

    public function envelope(): Envelope
    {
        $status = $this->inspeksi->dimensi === 'REJECT' || $this->inspeksi->visual === 'REJECT'
            ? 'REJECT' : 'NG';

        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->inspeksi->lot_number} - {$status}",
        );
    }

    public function content(): Content
    {
        $insbb = $this->inspeksi->incomingbahanbaku;
        $status = $this->inspeksi->dimensi === 'REJECT' || $this->inspeksi->visual === 'REJECT'
            ? 'REJECT' : 'NG';

        return new Content(
            html: 'emails.inspeksi-bb-lot-notification',
            with: [
                'lotNumber'      => $this->inspeksi->lot_number,
                'nomorInspeksi'  => $insbb?->nomor_inspeksi ?? '-',
                'tanggal'        => $insbb?->tanggal ?? '-',
                'supplier'       => $insbb?->supplier?->nama ?? '-',
                'noPo'           => $insbb?->no_po ?? '-',
                'noSj'           => $insbb?->no_sj ?? '-',
                'jenisKawat'     => $insbb?->jenis_kawat ?? '-',
                'dKawat'         => $insbb?->d_kawat ?? '-',
                'noKoil'         => $this->inspeksi->no_koil,
                'status'         => $status,
                'd1'             => $this->inspeksi->d1,
                'd2'             => $this->inspeksi->d2,
                'd3'             => $this->inspeksi->d3,
                'rataRata'       => $this->inspeksi->rata_rata,
                'dimensi'        => $this->inspeksi->dimensi,
                'visual'         => $this->inspeksi->visual,
                'description1'   => $this->inspeksi->description1,
                'description2'   => $this->inspeksi->description2,
                'user'           => $this->inspeksi->user?->name,
            ],
        );
    }
}
