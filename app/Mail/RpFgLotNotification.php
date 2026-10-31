<?php

namespace App\Mail;

use App\Models\InspeksiRazorpackingFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RpFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiRazorpackingFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiRazorpacking = $this->fg->inspeksiRazorpacking;
        $pro = $inspeksiRazorpacking->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber'   => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiRazorpacking->nomor_inspeksi,
                'shift'       => $inspeksiRazorpacking->shift,
                'proId'       => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin'   => $inspeksiRazorpacking->mesin?->nama_mesin,
                'status'      => $this->fg->status,
                'qty'         => $this->fg->qty,
                'weight'      => $this->fg->weight,
                'tanggal'     => $inspeksiRazorpacking->tanggal,
                'user'        => $this->fg->user?->name,
                'details'     => $this->fg->details,
            ],
        );
    }
}
