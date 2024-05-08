<?php

namespace App\Core\Application\Service\GetDetailSeri;

use Exception;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlGenreRepository;
use App\Infrastructure\Repository\SqlPenerbitRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPenulisRepository;

class GetDetailSeriService
{
    private SqlSeriRepository $seri_repository;
    private SqlVolumeRepository $volume_repository;
    private SqlPenulisRepository $penulis_repository;
    private SqlGenreRepository $genre_repository;
    private SqlPenerbitRepository $penerbit_repository;

    /**
     * @param SqlSeriRepository $seri_repository
     * @param SqlVolumeRepository $volume_repository
     * @param SqlPenulisRepository $penulis_repository
     * @param SqlGenreRepository $genre_repository
     * @param SqlPenerbitRepository $penerbit_repository
     */
    public function __construct(SqlSeriRepository $seri_repository, SqlVolumeRepository $volume_repository, SqlPenulisRepository $penulis_repository, SqlGenreRepository $genre_repository, SqlPenerbitRepository $penerbit_repository)
    {
        $this->seri_repository = $seri_repository;
        $this->volume_repository = $volume_repository;
        $this->penulis_repository = $penulis_repository;
        $this->genre_repository = $genre_repository;
        $this->penerbit_repository = $penerbit_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $seri_id)
    {
        $detail_seri = $this->seri_repository->find($seri_id);
        if (!$detail_seri) {
            return;
        }

        $list_volume = $this->volume_repository->getVolumeBySeriId($detail_seri->getId());
        $volume = [];
        foreach ($list_volume as $vol) {
            $volume[] = new GetVolumeResponse(
                $vol->getId(),
                $vol->getVolume(),
                $vol->getJumlahTersedia(),
                $vol->getHargaSewa(),
                $vol->getSeriId()
            );
        }
        $list_penulis = $this->penulis_repository->getPenulisBySeriId($detail_seri->getId());
        $penulis = [];
        foreach ($list_penulis as $pen) {
            $penulis[] = new GetPenulisResponse(
                $pen->getId(),
                $pen->getNamaDepan(),
                $pen->getNamaBelakang(),
                $pen->getPeran(),
            );
        }
        $list_genre = $this->genre_repository->getGenreBySeriId($detail_seri->getId());
        $genre = [];
        foreach ($list_genre as $gen) {
            $genre[] = new GetGenreResponse(
                $gen->getId(),
                $gen->getNama(),
            );
        }

        $penerbit = $this->penerbit_repository->find($detail_seri->getPenerbitId());
        return new GetDetailSeriResponse(
            $detail_seri->getId(),
            $detail_seri->getJudul(),
            $detail_seri->getSinopsis(),
            $detail_seri->getTahunTerbit(),
            $detail_seri->getSkor(),
            $detail_seri->getFoto(),
            $penerbit,
            $volume,
            $penulis,
            $genre,
        );
    }
}
