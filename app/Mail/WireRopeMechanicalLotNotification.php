<?php

namespace App\Mail;

use App\Models\IncomingWireRope;
use App\Models\IncomingWireRopeInspeksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WireRopeMechanicalLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IncomingWireRopeInspeksi $inspeksi,
    ) {}

    public function envelope(): Envelope
    {
        $status = $this->inspeksi->mechanical_status === 'REJECT' ? 'REJECT' : 'NG';

        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->inspeksi->mechanical_lot_number} - {$status}",
        );
    }

    public function content(): Content
    {
        $parent = IncomingWireRope::with('supplier')->find($this->inspeksi->incoming_wire_rope_id);
        $status = $this->inspeksi->mechanical_status === 'REJECT' ? 'REJECT' : 'NG';

        return new Content(
            html: 'emails.wire-rope-mechanical-lot-notification',
            with: [
                'lotNumber' => $this->inspeksi->mechanical_lot_number,
                'nomorInspeksi' => $parent?->nomor_inspeksi ?? '-',
                'tanggal' => $parent?->tanggal ?? '-',
                'supplier' => $parent?->supplier?->nama ?? '-',
                'noPo' => $parent?->no_po ?? '-',
                'noSj' => $parent?->no_sj ?? '-',
                'jenisKawat' => $parent?->jenis_kawat ?? '-',
                'dKawat' => $parent?->d_kawat ?? '-',
                'noKoil' => $this->inspeksi->no_koil,
                'status' => $status,
                'tensileStrength' => $this->inspeksi->tensile_strength_kawat_inti,
                'user' => \App\Models\User::find($this->inspeksi->mechanical_user_id)?->name ?? '-',
            ],
        );
    }
}
