<?php

namespace App\Core\Domain\Models\PeminjamanVolume;

use Illuminate\Database\Eloquent\Model;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolumeId;

class PeminjamanVolume extends Model
{
    private PeminjamanVolumeId $id;
    private PeminjamanId $peminjaman_id;
    private int $volume_id;

    /**
     * @param PeminjamanVolumeId $id
     * @param PeminjamanId $peminjaman_id
     * @param int $volume_id
     */
    public function __construct(PeminjamanVolumeId $id, PeminjamanId $peminjaman_id, int $volume_id)
    {
        $this->id = $id;
        $this->peminjaman_id = $peminjaman_id;
        $this->volume_id = $volume_id;
    }

    public static function create(PeminjamanId $peminjaman_id, int $volume_id)
    {
        return new self(
            PeminjamanVolumeId::generate(),
            $peminjaman_id,
            $volume_id
        );
    }

    public function getId(): PeminjamanVolumeId
    {
        return $this->id;
    }

    public function getPeminjamanId(): PeminjamanId
    {
        return $this->peminjaman_id;
    }

    public function getVolumeId(): int
    {
        return $this->volume_id;
    }
}
