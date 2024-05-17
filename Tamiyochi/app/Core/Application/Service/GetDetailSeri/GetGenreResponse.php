<?php

namespace App\Core\Application\Service\GetDetailSeri;

use JsonSerializable;

class GetGenreResponse implements JsonSerializable
{
    private int $id;
    private string $nama;


    public function __construct(int $id, string $nama)
    {
        $this->id = $id;
        $this->nama = $nama;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
        ];
    }
}
