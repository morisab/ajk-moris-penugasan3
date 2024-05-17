<?php

namespace App\Core\Application\Service\GetMyPeminjaman;

use JsonSerializable;

class GetMyPeminjamanResponse implements JsonSerializable
{
    private int $volume_id;
    private string $status;
    private string $tanggal_peminjaman;
    private string $tanggal_pengembalian;
    private string $sisa_hari;
    private string $volume;
    private string $judul;
    private string $penulis_nama_depan;
    private string $penulis_nama_belakang;
    private string $foto;

    public function __construct(int $volume_id, string $status, string $tanggal_peminjaman, string $tanggal_pengembalian, string $sisa_hari, string $volume, string $judul, string $penulis_nama_depan, string $penulis_nama_belakang, string $foto)
    {
        $this->volume_id = $volume_id;
        $this->status = $status;
        $this->tanggal_peminjaman = $tanggal_peminjaman;
        $this->tanggal_pengembalian = $tanggal_pengembalian;
        $this->sisa_hari = $sisa_hari;
        $this->volume = $volume;
        $this->judul = $judul;
        $this->penulis_nama_depan = $penulis_nama_depan;
        $this->penulis_nama_belakang = $penulis_nama_belakang;
        $this->foto = $foto;
    }

    public function jsonSerialize(): array
    {
        return [
            'volume_id' => $this->volume_id,
            'status' => $this->status,
            'tanggal_peminjaman' => $this->tanggal_peminjaman,
            'tanggal_pengembalian' => $this->tanggal_pengembalian,
            'sisa_hari' => $this->sisa_hari,
            'volume' => $this->volume,
            'judul' => $this->judul,
            'penulis_nama_depan' => $this->penulis_nama_depan,
            'penulis_nama_belakang' => $this->penulis_nama_belakang,
            'foto' => $this->foto,
        ];
    }
}
