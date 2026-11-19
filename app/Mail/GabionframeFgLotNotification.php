<?php

namespace App\Mail;

use App\Models\InspeksiGabionframeFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GabionframeFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiGabionframeFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksi = $this->fg->inspeksiGabionframe;
        $pro = $inspeksi?->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber' => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksi?->nomor_inspeksi,
                'shift' => $inspeksi?->shift,
                'proId' => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin' => $inspeksi?->mesin?->nama_mesin,
                'status' => $this->fg->status,
                'qty' => $this->fg->qty,
                'weight' => $this->fg->weight,
                'tanggal' => $inspeksi?->tanggal,
                'user' => $this->fg->user?->name,
                'details' => $this->fg->details,
            ],
        );
    }
}
