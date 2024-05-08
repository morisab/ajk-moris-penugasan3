<?php

namespace App\Core\Application\Service\GetMyPeminjaman;

use Exception;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPeminjamanRepository;
use App\Infrastructure\Repository\SqlPeminjamanVolumeRepository;
use App\Core\Application\Service\GetMyPeminjaman\GetMyPeminjamanResponse;
use App\Infrastructure\Repository\SqlPenulisRepository;
use App\Infrastructure\Repository\SqlSeriPenulisRepository;
use Carbon\Carbon;
use DateTime;

class GetMyPeminjamanService
{
    private SqlPeminjamanRepository $peminjaman_repository;
    private SqlPeminjamanVolumeRepository $peminjaman_volume_repository;
    private SqlVolumeRepository $volume_repository;
    private SqlSeriRepository $seri_repository;
    private SqlPenulisRepository $penulis_repository;
    private SqlSeriPenulisRepository $seri_penulis_repository;

    public function __construct(SqlPeminjamanRepository $peminjaman_repository, SqlPeminjamanVolumeRepository $peminjaman_volume_repository, SqlVolumeRepository $volume_repository, SqlSeriRepository $seri_repository, SqlPenulisRepository $penulis_repository, SqlSeriPenulisRepository $seri_penulis_repository)
    {
        $this->peminjaman_repository = $peminjaman_repository;
        $this->peminjaman_volume_repository = $peminjaman_volume_repository;
        $this->volume_repository = $volume_repository;
        $this->seri_repository = $seri_repository;
        $this->penulis_repository = $penulis_repository;
        $this->seri_penulis_repository = $seri_penulis_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $user_id)
    {
        $peminjamans = $this->peminjaman_repository->getAllPeminjamanByUserId($user_id);
        $peminjaman_response = [];
        foreach ($peminjamans as $peminjaman) {
            $peminjaman_volumes = $this->peminjaman_volume_repository->getAllPeminjamanVolumeByPeminjamanId($peminjaman->getId());
            foreach ($peminjaman_volumes as $peminjaman_volume) {
                $volume = $this->volume_repository->find($peminjaman_volume->getVolumeId());
                $seri = $this->seri_repository->find($volume->getSeriId());
                $seri_penulis = $this->seri_penulis_repository->findFirst($seri->getId());
                $penulis = $this->penulis_repository->find($seri_penulis->getSeriId());

                $tanggal_pengembalian = Carbon::parse($peminjaman->getPaidAt())->addDays(7);
                $sisa_hari = $tanggal_pengembalian->diff(Carbon::now());
                $peminjaman_response[] = new GetMyPeminjamanResponse(
                    $volume->getId(),
                    $peminjaman->getStatus(),
                    $peminjaman->getPaidAt(),
                    $tanggal_pengembalian,
                    $sisa_hari->days + 1,
                    $volume->getVolume(),
                    $seri->getJudul(),
                    $penulis->getNamaDepan(),
                    $penulis->getNamaBelakang(),
                    $seri->getFoto(),
                );
            }
        }
        return $peminjaman_response;
    }
}
