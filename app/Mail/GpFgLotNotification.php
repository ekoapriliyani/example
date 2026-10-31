<?php

namespace App\Mail;

use App\Models\InspeksiGabionpackingFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GpFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiGabionpackingFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiGabionpacking = $this->fg->inspeksiGabionpacking;
        $pro = $inspeksiGabionpacking->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber'   => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiGabionpacking->nomor_inspeksi,
                'shift'       => $inspeksiGabionpacking->shift,
                'proId'       => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin'   => $inspeksiGabionpacking->mesin?->nama_mesin,
                'status'      => $this->fg->status,
                'qty'         => $this->fg->qty,
                'weight'      => $this->fg->weight,
                'tanggal'     => $inspeksiGabionpacking->tanggal,
                'user'        => $this->fg->user?->name,
                'details'     => $this->fg->details,
            ],
        );
    }
}
