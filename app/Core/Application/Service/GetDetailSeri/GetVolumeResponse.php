<?php

namespace App\Core\Application\Service\GetDetailSeri;

use JsonSerializable;

class GetVolumeResponse implements JsonSerializable
{
    private int $id;
    private string $volume;
    private string $jumlah_tersedia;
    private string $harga_sewa;
    private string $seri_id;


    public function __construct(int $id, string $volume, string $jumlah_tersedia, string $harga_sewa, string $seri_id)
    {
        $this->id = $id;
        $this->volume = $volume;
        $this->jumlah_tersedia = $jumlah_tersedia;
        $this->harga_sewa = $harga_sewa;
        $this->seri_id = $seri_id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'volume' => $this->volume,
            'jumlah_tersedia' => $this->jumlah_tersedia,
            'harga_sewa' => $this->harga_sewa,
            'seri_id' => $this->seri_id
        ];
    }
}
