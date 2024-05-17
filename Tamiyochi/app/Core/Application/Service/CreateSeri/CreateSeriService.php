<?php

namespace App\Core\Application\Service\CreateSeri;

use Exception;
use App\Core\Domain\Models\Cart\Cart;
use App\Core\Domain\Models\Seri\Seri;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\SeriGenre\SeriGenre;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Domain\Models\SeriPenulis\SeriPenulis;
use App\Core\Domain\Models\Volume\Volume;
use App\Infrastructure\Repository\SqlCartRepository;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlGenreRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPenulisRepository;
use App\Infrastructure\Repository\SqlPenerbitRepository;
use App\Infrastructure\Repository\SqlSeriGenreRepository;
use App\Infrastructure\Repository\SqlSeriPenulisRepository;

class CreateSeriService
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
    public function execute(CreateSeriRequest $request)
    {
        $check_penerbit = $this->penerbit_repository->find($request->getPenerbitId());
        if (!$check_penerbit) {
            throw new Exception("Penerbit tidak ditemukan");
        }

        foreach ($request->getPenulisId() as $penulis) {
            $check_penulis = $this->penulis_repository->find($penulis);
            if (!$check_penulis) {
                throw new Exception("Penulis tidak ditemukan");
            }
        }

        foreach ($request->getGenreId() as $genre) {
            $check_genre = $this->genre_repository->find($genre);
            if (!$check_genre) {
                throw new Exception("Genre tidak ditemukan");
            }
        }

        $image_url = ImageUpload::create(
            $request->getFoto(),
            'images',
            $request->getJudul(),
            'seri'
        )->upload();

        $seri_id = $this->seri_repository->getLastSeriId();
        $seri = Seri::create(
            $seri_id + 1,
            $request->getPenerbitId(),
            $request->getJudul(),
            $request->getSinopsis(),
            $request->getTahunTerbit(),
            10,
            $image_url
        );

        $this->seri_repository->persist($seri);

        foreach ($request->getPenulisId() as $penulis) {
            $seri_penulis_id = $this->seri_penulis_repository->getLastSeriPenulisId();
            $seri_penulis = SeriPenulis::create(
                $seri_penulis_id + 1,
                $seri->getId(),
                $penulis
            );
            $this->seri_penulis_repository->persist($seri_penulis);
        }

        foreach ($request->getGenreId() as $genre) {
            $seri_genre_id = $this->seri_genre_repository->getLastSeriGenreId();
            $seri_genre = SeriGenre::create(
                $seri_genre_id + 1,
                $seri->getId(),
                $genre
            );
            $this->seri_genre_repository->persist($seri_genre);
        }

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

        return $seri_id + 1;
    }
}
