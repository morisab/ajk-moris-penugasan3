<?php

namespace App\Core\Application\Service\CreateGenre;

use Exception;
use App\Core\Domain\Models\Genre\Genre;
use App\Infrastructure\Repository\SqlGenreRepository;

class CreateGenreService
{
    private SqlGenreRepository $genre_repository;

    public function __construct(SqlGenreRepository $genre_repository)
    {
        $this->genre_repository = $genre_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $name)
    {
        $check_genre = $this->genre_repository->findByName($name);
        if ($check_genre) {
            throw new Exception("Genre sudah ada");
        }
        $genre_id = $this->genre_repository->getLastGenreId();
        $input = Genre::create(
            $genre_id + 1,
            $name
        );
        $this->genre_repository->persist($input);
    }
}
