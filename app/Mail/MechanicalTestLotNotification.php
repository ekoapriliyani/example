<?php

namespace App\Mail;

use App\Models\IncomingBahanBaku;
use App\Models\MechanicalTest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MechanicalTestLotNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public MechanicalTest $mechanicalTest,
    ) {}

    public function envelope(): Envelope
    {
        $status = $this->mechanicalTest->status === 'REJECT' ? 'REJECT' : 'NG';

        return new Envelope(
            subject: "[NOTIFIKASI] Lot Number {$this->mechanicalTest->lot_number} - {$status}",
        );
    }

    public function content(): Content
    {
        $inc = IncomingBahanBaku::with('supplier')->find($this->mechanicalTest->incoming_bahan_baku_id);
        $status = $this->mechanicalTest->status === 'REJECT' ? 'REJECT' : 'NG';

        return new Content(
            html: 'emails.mechanical-test-lot-notification',
            with: [
                'lotNumber'      => $this->mechanicalTest->lot_number,
                'nomorInspeksi'  => $inc?->nomor_inspeksi ?? '-',
                'tanggal'        => $inc?->tanggal ?? '-',
                'supplier'       => $inc?->supplier?->nama ?? '-',
                'noPo'           => $inc?->no_po ?? '-',
                'noSj'           => $inc?->no_sj ?? '-',
                'jenisKawat'     => $inc?->jenis_kawat ?? '-',
                'dKawat'         => $inc?->d_kawat ?? '-',
                'nomorKoil'      => $this->mechanicalTest->nomor_koil,
                'status'         => $status,
                'hasilTensile'   => $this->mechanicalTest->hasil_tensile,
                'hasilCoating'   => $this->mechanicalTest->hasil_coatingweight,
                'hasilLilit'     => $this->mechanicalTest->hasil_lilit,
                'hasilPuntir'    => $this->mechanicalTest->hasil_puntir,
                'description1'   => $this->mechanicalTest->description1,
                'description2'   => $this->mechanicalTest->description2,
                'user'           => \App\Models\User::find($this->mechanicalTest->user_id)?->name ?? '-',
            ],
        );
    }
}
