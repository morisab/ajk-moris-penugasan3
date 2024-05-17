<?php

namespace App\Core\Domain\Models\Peminjaman;

use App\Core\Domain\Models\User\UserId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolume;

class Peminjaman extends Model
{
    private PeminjamanId $id;
    private UserId $user_id;
    private string $paid_at;
    private string $invoice_url;
    private string $status;
    private int $jumlah;
    private int $harga_total;

    /**
     * @param PeminjamanId $id
     * @param UserId $user_id
     * @param string $paid_at
     * @param string $invoice_url
     * @param string $status
     * @param int $jumlah
     * @param int $harga_total
     */
    public function __construct(PeminjamanId $id, UserId $user_id, string $paid_at, string $invoice_url, string $status, int $jumlah, int $harga_total)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->paid_at = $paid_at;
        $this->invoice_url = $invoice_url;
        $this->status = $status;
        $this->jumlah = $jumlah;
        $this->harga_total = $harga_total;
    }

    public static function create(PeminjamanId $id, UserId $user_id, string $paid_at, string $invoice_url, string $status, int $jumlah, int $harga_total)
    {
        return new self(
            $id,
            $user_id,
            $paid_at,
            $invoice_url,
            $status,
            $jumlah,
            $harga_total
        );
    }

    public function getId(): PeminjamanId
    {
        return $this->id;
    }
    
    public function getUserId(): UserId
    {
        return $this->user_id;
    }

    public function getPaidAt(): string
    {
        return $this->paid_at;
    }

    public function getInvoiceUrl(): string
    {
        return $this->invoice_url;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getJumlah(): int
    {
        return $this->jumlah;
    }

    public function getHargaTotal(): int
    {
        return $this->harga_total;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function peminjamanVolume(): HasMany
    {
        return $this->hasMany(PeminjamanVolume::class);
    }
}
