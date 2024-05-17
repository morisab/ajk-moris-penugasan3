<?php

namespace App\Core\Application\Service\GetSeriList;

use JsonSerializable;

class GetGenreResponse implements JsonSerializable
{
    private string $id;
    private string $nama;
    

    public function __construct(string $id, string $nama)
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
