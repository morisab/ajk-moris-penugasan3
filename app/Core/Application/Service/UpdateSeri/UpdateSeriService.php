<?php

namespace App\Core\Application\Service\UpdateSeri;

use Exception;
use App\Core\Domain\Models\Seri\Seri;
use App\Core\Domain\Models\SeriGenre\SeriGenre;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\SeriPenulis\SeriPenulis;
use App\Core\Domain\Models\Volume\Volume;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlGenreRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPenulisRepository;
use App\Infrastructure\Repository\SqlPenerbitRepository;
use App\Infrastructure\Repository\SqlSeriGenreRepository;
use App\Infrastructure\Repository\SqlSeriPenulisRepository;

class UpdateSeriService
{
    private SqlSeriRepository $seri_repository;
    private SqlPenerbitRepository $penerbit_repository;
    private SqlPenulisRepository $penulis_repository;
    private SqlGenreRepository $genre_repository;
    private SqlSeriPenulisRepository $seri_penulis_repository;
    private SqlSeriGenreRepository $seri_genre_repository;
    private SqlVolumeRepository $volume_repository;

    public function __construct(SqlSeriRepository $seri_repository, SqlPenerbitRepository $penerbit_repository, SqlPenulisRepository $penulis_repository, SqlGenreRepository $genre_repository, SqlSeriPenulisRepository $seri_penulis_repository, SqlSeriGenreRepository $seri_genre_repository, SqlVolumeRepository $volume_repository)
    {
        $this->seri_repository = $seri_repository;
        $this->penerbit_repository = $penerbit_repository;
        $this->penulis_repository = $penulis_repository;
        $this->genre_repository = $genre_repository;
        $this->seri_penulis_repository = $seri_penulis_repository;
        $this->seri_genre_repository = $seri_genre_repository;
        $this->volume_repository = $volume_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(UpdateSeriRequest $request)
    {
        $seri = $this->seri_repository->find($request->getId());
        if (!$seri) {
            throw new Exception("Seri tidak ditemukan");
        }
        $this->seri_penulis_repository->deleteBySeriId($seri->getId());
        $this->seri_genre_repository->deleteBySeriId($seri->getId());
        $this->volume_repository->deleteBySeriId($seri->getId());

        if ($request->getPenerbitId()) {
            $check_penerbit = $this->penerbit_repository->find($request->getPenerbitId());
            if (!$check_penerbit) {
                throw new Exception("Penerbit tidak ditemukan");
            }
        }

        if ($request->getPenulisId()) {
            foreach ($request->getPenulisId() as $penulis) {
                $check_penulis = $this->penulis_repository->find($penulis);
                if (!$check_penulis) {
                    throw new Exception("Penulis tidak ditemukan");
                }
            }
        }

        if ($request->getGenreId()) {
            foreach ($request->getGenreId() as $genre) {
                $check_genre = $this->genre_repository->find($genre);
                if (!$check_genre) {
                    throw new Exception("Genre tidak ditemukan");
                }
            }
        }

        $imageUrl = null;
        if ($request->getFoto()) {
            $imageUrl = ImageUpload::create(
                $request->getFoto(),
                'images',
                $request->getJudul(),
                'seri'
            )->upload();
        }

        $seriUpdate = Seri::create(
            $seri->getId(),
            $request->getPenerbitId() ?? $seri->getPenerbitId(),
            $request->getJudul() ?? $seri->getJudul(),
            $request->getSinopsis() ?? $seri->getSinopsis(),
            $request->getTahunTerbit() ?? $seri->getTahunTerbit(),
            10,
            $imageUrl ?? $seri->getFoto()
        );

        $this->seri_repository->persist($seriUpdate);

        if ($request->getPenulisId()) {
            foreach ($request->getPenulisId() as $penulis) {
                $seri_penulis_id = $this->seri_penulis_repository->getLastSeriPenulisId();
                $seri_penulis = SeriPenulis::create(
                    $seri_penulis_id + 1,
                    $seri->getId(),
                    $penulis
                );
                $this->seri_penulis_repository->persist($seri_penulis);
            }
        }

        if ($request->getGenreId()) {
            foreach ($request->getGenreId() as $genre) {
                $seri_genre_id = $this->seri_genre_repository->getLastSeriGenreId();
                $seri_genre = SeriGenre::create(
                    $seri_genre_id + 1,
                    $seri->getId(),
                    $genre
                );
                $this->seri_genre_repository->persist($seri_genre);
            }
        }

        if ($request->getVolume()) {
            foreach ($request->getVolume() as $volume) {
                $volume_id = $this->volume_repository->getLastVolumeId();
                $volumeSql = Volume::create(
                    $volume_id + 1,
                    $seri->getId(),
                    $volume['volume'],
                    $volume['jumlah_tersedia'],
                    $volume['harga_sewa']
                );
                $this->volume_repository->persist($volumeSql);
            }
        }

        return $seri->getId();
    }
}
