<?php

namespace App\Core\Application\Service\CreateSeriView;

use Exception;
use App\Infrastructure\Repository\SqlSeriRepository;
use App\Infrastructure\Repository\SqlGenreRepository;
use App\Infrastructure\Repository\SqlPenerbitRepository;
use App\Infrastructure\Repository\SqlVolumeRepository;
use App\Infrastructure\Repository\SqlPenulisRepository;

class CreateSeriViewService
{
    private SqlGenreRepository $genre_repository;
    private SqlPenulisRepository $penulis_repository;
    private SqlPenerbitRepository $penerbit_repository;

    public function __construct(SqlGenreRepository $genre_repository, SqlPenulisRepository $penulis_repository, SqlPenerbitRepository $penerbit_repository)
    {
        $this->genre_repository = $genre_repository;
        $this->penulis_repository = $penulis_repository;
        $this->penerbit_repository = $penerbit_repository;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $genres = $this->genre_repository->getAll();
        $penulis = $this->penulis_repository->getAll();
        $penerbit = $this->penerbit_repository->getAll();

        $response = [
            'genres' => $genres,
            'penulis' => $penulis,
            'penerbit' => $penerbit,
        ];
        return $response;
    }
}
