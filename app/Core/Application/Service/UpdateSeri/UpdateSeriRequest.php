<?php

namespace App\Core\Application\Service\UpdateSeri;

use Illuminate\Http\UploadedFile;

class UpdateSeriRequest
{
    private string $id;
    private ?string $judul;
    private ?string $sinopsis;
    private ?string $tahun_terbit;
    private ?UploadedFile $foto;
    private ?string $penerbit_id;
    private ?array $penulis_id;
    private ?array $genre_id;
    private ?array $volume;

    public function __construct(string $id, ?string $judul, ?string $sinopsis, ?string $tahun_terbit, ?UploadedFile $foto, ?string $penerbit_id, ?array $penulis_id, ?array $genre_id, ?array $volume)
    {
        $this->id = $id;
        $this->judul = $judul;
        $this->sinopsis = $sinopsis;
        $this->tahun_terbit = $tahun_terbit;
        $this->foto = $foto;
        $this->penerbit_id = $penerbit_id;
        $this->penulis_id = $penulis_id;
        $this->genre_id = $genre_id;
        $this->volume = $volume;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getJudul(): ?string
    {
        return $this->judul;
    }

    public function getSinopsis(): ?string
    {
        return $this->sinopsis;
    }

    public function getTahunTerbit(): ?string
    {
        return $this->tahun_terbit;
    }

    public function getFoto(): ?UploadedFile
    {
        return $this->foto;
    }

    public function getPenerbitId(): ?string
    {
        return $this->penerbit_id;
    }

    public function getPenulisId(): ?array
    {
        return $this->penulis_id;
    }

    public function getGenreId(): ?array
    {
        return $this->genre_id;
    }

    public function getVolume(): ?array
    {
        return $this->volume;
    }
}
