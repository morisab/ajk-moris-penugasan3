<?php

namespace App\Core\Application\Service\DeleteGenre;

use Exception;
use App\Infrastructure\Repository\SqlGenreRepository;

class DeleteGenreService
{
    private SqlGenreRepository $genre_repository;

    public function __construct(SqlGenreRepository $genre_repository)
    {
        $this->genre_repository = $genre_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $genre_id)
    {
        $this->genre_repository->delete($genre_id);
    }
}
