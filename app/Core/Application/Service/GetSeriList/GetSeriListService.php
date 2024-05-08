<?php

namespace App\Core\Application\Service\GetSeriList;

use Exception;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlGenreRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPenulisRepository;
use App\Core\Application\Service\GetSeriList\GetGenreResponse;
use App\Core\Application\Service\GetSeriList\GetVolumeResponse;

class GetSeriListService
{
    private SqlSeriRepository $seri_repository;
    private SqlVolumeRepository $volume_repository;
    private SqlPenulisRepository $penulis_repository;
    private SqlGenreRepository $genre_repository;

    /**
     * @param SqlSeriRepository $seri_repository
     * @param SqlVolumeRepository $volume_repository
     * @param SqlPenulisRepository $penulis_repository
     * @param SqlGenreRepository $genre_repository
     */
    public function __construct(SqlSeriRepository $seri_repository, SqlVolumeRepository $volume_repository, SqlPenulisRepository $penulis_repository, SqlGenreRepository $genre_repository)
    {
        $this->seri_repository = $seri_repository;
        $this->volume_repository = $volume_repository;
        $this->penulis_repository = $penulis_repository;
        $this->genre_repository = $genre_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(GetSeriListRequest $request)
    {
        $list_seri = $this->seri_repository->getAll($request->getPage(), $request->getPerPage(), $request->getSearch(), $request->getFilter());
        if (empty($list_seri)) {
            return [];
        }
        $response = [];
        foreach ($list_seri['data'] as $seri) {
            $list_volume = $this->volume_repository->getVolumeBySeriId($seri->getId());
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
            $list_penulis = $this->penulis_repository->getPenulisBySeriId($seri->getId());
            $penulis = [];
            foreach ($list_penulis as $pen) {
                $penulis[] = new GetPenulisResponse(
                    $pen->getId(),
                    $pen->getNamaDepan(),
                    $pen->getNamaBelakang(),
                    $pen->getPeran(),
                );
            }
            $list_genre = $this->genre_repository->getGenreBySeriId($seri->getId());
            $genre = [];
            foreach ($list_genre as $gen) {
                $genre[] = new GetGenreResponse(
                    $gen->getId(),
                    $gen->getNama(),
                );
            }
            $response[] = new GetSeriListResponse(
                $seri->getId(),
                $seri->getJudul(),
                $seri->getSinopsis(),
                $seri->getTahunTerbit(),
                $seri->getSkor(),
                $seri->getFoto(),
                $seri->getPenerbitId(),
                $volume,
                $penulis,
                $genre
            );
        }

        $meta = [
            'max_page' => $list_seri['max_page'],
            'genre' => $this->genre_repository->getAll()
        ];

        return [
            'data' => $response,
            'meta' => $meta
        ];
    }
}
