<?php

namespace App\Mail;

use App\Models\InspeksiWmFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiWmFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiWm = $this->fg->inspeksiWm;
        $pro = $inspeksiWm->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber' => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiWm->nomor_inspeksi,
                'proId' => $pro?->pro_id,
                'status' => $this->fg->status,
                'qty' => $this->fg->qty,
                'weight' => $this->fg->weight,
                'tanggal' => $inspeksiWm->tanggal,
                'user' => $this->fg->user?->name,
                'details' => $this->fg->details,
            ],
        );
    }
}
