<?php

namespace App\Mail;

use App\Models\IncomingWireRope;
use App\Models\IncomingWireRopeInspeksi;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class IncomingWireRopeLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public IncomingWireRopeInspeksi $inspeksi,
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
        $parent = IncomingWireRope::with('supplier')->find($this->inspeksi->incoming_wire_rope_id);
        $status = $this->inspeksi->dimensi === 'REJECT' || $this->inspeksi->visual === 'REJECT'
            ? 'REJECT' : 'NG';

        return new Content(
            html: 'emails.incoming-wire-rope-lot-notification',
            with: [
                'lotNumber' => $this->inspeksi->lot_number,
                'nomorInspeksi' => $parent?->nomor_inspeksi ?? '-',
                'tanggal' => $parent?->tanggal ?? '-',
                'supplier' => $parent?->supplier?->nama ?? '-',
                'noPo' => $parent?->no_po ?? '-',
                'noSj' => $parent?->no_sj ?? '-',
                'jenisKawat' => $parent?->jenis_kawat ?? '-',
                'dKawat' => $parent?->d_kawat ?? '-',
                'noKoil' => $this->inspeksi->no_koil,
                'status' => $status,
                'd1WireRope' => $this->inspeksi->d1_wire_rope,
                'd2WireRope' => $this->inspeksi->d2_wire_rope,
                'd3WireRope' => $this->inspeksi->d3_wire_rope,
                'd1KawatInti' => $this->inspeksi->d1_kawat_inti,
                'd2KawatInti' => $this->inspeksi->d2_kawat_inti,
                'd3KawatInti' => $this->inspeksi->d3_kawat_inti,
                'jmlKawatInti' => $this->inspeksi->jml_kawat_inti,
                'dimensi' => $this->inspeksi->dimensi,
                'visual' => $this->inspeksi->visual,
                'description1' => $this->inspeksi->description1,
                'description2' => $this->inspeksi->description2,
                'user' => \App\Models\User::find($this->inspeksi->user_id)?->name ?? '-',
            ],
        );
    }
}
