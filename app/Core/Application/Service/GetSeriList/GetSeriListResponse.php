<?php

namespace App\Core\Application\Service\GetSeriList;

use JsonSerializable;

class GetSeriListResponse implements JsonSerializable
{
    private string $id;
    private string $judul;
    private string $sinopsis;
    private string $tahun_terbit;
    private string $skor;
    private string $foto;
    private string $penerbit_id;
    private array $volume;
    private array $penulis;
    private array $genre;

    public function __construct(string $id, string $judul, string $sinopsis, string $tahun_terbit, string $skor, string $foto, string $penerbit_id, array $volume, array $penulis, array $genre)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->sinopsis = $sinopsis;
        $this->tahun_terbit = $tahun_terbit;
        $this->skor = $skor;
        $this->foto = $foto;
        $this->penerbit_id = $penerbit_id;
        $this->volume = $volume;
        $this->penulis = $penulis;
        $this->genre = $genre;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'sinopsis' => $this->sinopsis,
            'tahun_terbit' => $this->tahun_terbit,
            'skor' => $this->skor,
            'foto' => $this->foto,
            'penerbit_id' => $this->penerbit_id,
            'volume' => $this->volume,
            'penulis' => $this->penulis,
            'genre' => $this->genre
        ];
    }
}
