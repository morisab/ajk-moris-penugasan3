<?php

namespace App\Core\Application\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeminjamanExpiredEmail extends Mailable
{
    use Queueable, SerializesModels;

    private string $peminjaman_id;

    /**
     * @param string $peminjaman_id
     */
    public function __construct(string $peminjaman_id)
    {
        $this->peminjaman_id = $peminjaman_id;
    }

    public function build(): PeminjamanExpiredEmail
    {
        return $this->from(config('mail.from'))
            ->markdown('email.peminjaman_expired_email', [
                "peminjaman_id" => $this->peminjaman_id,
            ]);
    }
}
