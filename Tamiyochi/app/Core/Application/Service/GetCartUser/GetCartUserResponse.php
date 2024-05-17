<?php

namespace App\Core\Application\Service\GetCartUser;

use JsonSerializable;

class GetCartUserResponse implements JsonSerializable
{
    private int $volume_id;
    private string $foto;
    private int $jumlah_tersedia;
    private int $jumlah_sewa;
    private int $harga_sewa;
    private int $volume;
    private int $harga_sub_total;
    private string $judul_seri;

    public function __construct(int $volume_id, string $foto, int $jumlah_tersedia, int $jumlah_sewa, int $harga_sewa, int $volume, int $harga_sub_total, string $judul_seri)
    {
        $this->volume_id = $volume_id;
        $this->foto = $foto;
        $this->jumlah_tersedia = $jumlah_tersedia;
        $this->jumlah_sewa = $jumlah_sewa;
        $this->harga_sewa = $harga_sewa;
        $this->volume = $volume;
        $this->harga_sub_total = $harga_sub_total;
        $this->judul_seri = $judul_seri;
    }

    public function jsonSerialize(): array
    {
        return [
            'volume_id' => $this->volume_id,
            'foto' => $this->foto,
            'jumlah_tersedia' => $this->jumlah_tersedia,
            'jumlah_sewa' => $this->jumlah_sewa,
            'harga_sewa' => $this->harga_sewa,
            'volume' => $this->volume,
            'harga_sub_total' => $this->harga_sub_total,
            'judul_seri' => $this->judul_seri,
        ];
    }
}
