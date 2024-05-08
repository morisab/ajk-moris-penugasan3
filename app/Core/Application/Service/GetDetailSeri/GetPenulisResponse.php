<?php

namespace App\Core\Application\Service\GetDetailSeri;

use JsonSerializable;

class GetPenulisResponse implements JsonSerializable
{
    private int $id;
    private string $nama_depan;
    private string $nama_belakang;
    private string $peran;


    public function __construct(int $id, string $nama_depan, string $nama_belakang, string $peran)
    {
        $this->id = $id;
        $this->nama_depan = $nama_depan;
        $this->nama_belakang = $nama_belakang;
        $this->peran = $peran;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nama_depan' => $this->nama_depan,
            'nama_belakang' => $this->nama_belakang,
            'peran' => $this->peran
        ];
    }
}
