<?php

namespace App\Mail;

use App\Models\InspeksiKawatDuriFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KdFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiKawatDuriFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiKawatDuri = $this->fg->inspeksiKawatDuri;
        $pro = $inspeksiKawatDuri->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber'   => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiKawatDuri->nomor_inspeksi,
                'shift'       => $inspeksiKawatDuri->shift,
                'proId'       => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin'   => $inspeksiKawatDuri->mesin?->nama_mesin,
                'status'      => $this->fg->status,
                'qty'         => $this->fg->qty,
                'weight'      => $this->fg->weight,
                'tanggal'     => $inspeksiKawatDuri->tanggal,
                'user'        => $this->fg->user?->name,
                'details'     => $this->fg->inspeksiKdFgDetails,
            ],
        );
    }
}
