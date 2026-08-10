<?php

namespace App\Mail;

use App\Models\InspeksiFencingFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FencingFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiFencingFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiFencing = $this->fg->inspeksiFencing;
        $pro = $inspeksiFencing->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber' => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiFencing->nomor_inspeksi,
                'shift' => $inspeksiFencing->shift,
                'proId' => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin' => $inspeksiFencing->mesin?->nama_mesin,
                'status' => $this->fg->status,
                'qty' => $this->fg->qty,
                'weight' => $this->fg->weight,
                'tanggal' => $inspeksiFencing->tanggal,
                'user' => $this->fg->user?->name,
                'details' => $this->fg->details,
            ],
        );
    }
}
