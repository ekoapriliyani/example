<?php

namespace App\Mail;

use App\Models\InspeksiCtFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CtFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiCtFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiCt = $this->fg->inspeksiCt;
        $pro = $inspeksiCt->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber' => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiCt->nomor_inspeksi,
                'shift' => $inspeksiCt->shift,
                'proId' => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin' => $inspeksiCt->mesin?->nama_mesin,
                'status' => $this->fg->status,
                'qty' => $this->fg->qty,
                'weight' => $this->fg->weight,
                'tanggal' => $inspeksiCt->tanggal,
                'user' => $this->fg->user?->name,
                'details' => $this->fg->details,
            ],
        );
    }
}
