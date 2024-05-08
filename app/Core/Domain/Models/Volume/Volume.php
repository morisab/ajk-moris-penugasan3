<?php

namespace App\Core\Domain\Models\Volume;

use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolume;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Volume extends Model
{
    private int $id;
    private int $seri_id;
    private int $volume;
    private int $jumlah_tersedia;
    private int $harga_sewa;

    /**
     * @param int $id
     * @param int $seri_id
     * @param int $volume
     * @param int $jumlah_tersedia
     * @param int $harga_sewa
     */
    public function __construct(int $id, int $seri_id, int $volume, int $jumlah_tersedia, int $harga_sewa)
    {
        $this->id = $id;
        $this->seri_id = $seri_id;
        $this->volume = $volume;
        $this->jumlah_tersedia = $jumlah_tersedia;
        $this->harga_sewa = $harga_sewa;
    }

    public static function create(int $id, int $seri_id, int $volume, int $jumlah_tersedia, int $harga_sewa)
    {
        return new self(
            $id,
            $seri_id,
            $volume,
            $jumlah_tersedia,
            $harga_sewa
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSeriId(): int
    {
        return $this->seri_id;
    }

    /**
     * @return int
     */
    public function getVolume(): int
    {
        return $this->volume;
    }

    /**
     * @return int
     */
    public function getJumlahTersedia(): int
    {
        return $this->jumlah_tersedia;
    }

    /**
     * @return int
     */
    public function getHargaSewa(): int
    {
        return $this->harga_sewa;
    }

    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function peminjamanVolume(): HasMany
    {
        return $this->hasMany(PeminjamanVolume::class);
    }
}
