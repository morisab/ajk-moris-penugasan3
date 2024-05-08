<?php

namespace App\Core\Application\Service\CreateCart;

use Illuminate\Http\UploadedFile;

class CreateCartRequest
{
    private int $volume_id;
    private int $jumlah;

    /**
     * @param int $volume_id
     * @param int $jumlah
     */
    public function __construct(int $volume_id, int $jumlah)
    {
        $this->volume_id = $volume_id;
        $this->jumlah = $jumlah;
    }

    /**
     * @return int
     */
    public function getVolumeId(): int
    {
        return $this->volume_id;
    }

    /**
     * @return int
     */
    public function getJumlah(): int
    {
        return $this->jumlah;
    }

}
