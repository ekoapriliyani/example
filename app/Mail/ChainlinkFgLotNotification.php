<?php

namespace App\Mail;

use App\Models\InspeksiChainlinkFg;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChainlinkFgLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InspeksiChainlinkFg $fg,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->fg->lot_number} - {$this->fg->status}",
        );
    }

    public function content(): Content
    {
        $inspeksiChainlink = $this->fg->inspeksiChainlink;
        $pro = $inspeksiChainlink->pro;

        return new Content(
            html: 'emails.fg-lot-notification',
            with: [
                'lotNumber'   => $this->fg->lot_number,
                'nomorInspeksi' => $inspeksiChainlink->nomor_inspeksi,
                'shift'       => $inspeksiChainlink->shift,
                'proId'       => $pro?->pro_id,
                'description' => $pro?->description,
                'namaMesin'   => $inspeksiChainlink->mesin?->nama_mesin,
                'status'      => $this->fg->status,
                'qty'         => $this->fg->qty,
                'weight'      => $this->fg->weight,
                'tanggal'     => $inspeksiChainlink->tanggal,
                'user'        => $this->fg->user?->name,
                'details'     => $this->fg->inspeksiChainlinkFgDetails,
            ],
        );
    }
}
