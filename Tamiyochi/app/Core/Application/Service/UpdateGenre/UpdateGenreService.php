<?php

namespace App\Core\Application\Service\UpdateGenre;

use Exception;
use App\Core\Domain\Models\Genre\Genre;
use App\Infrastructure\Repository\SqlGenreRepository;

class UpdateGenreService
{
    private SqlGenreRepository $genre_repository;

    public function __construct(SqlGenreRepository $genre_repository)
    {
        $this->genre_repository = $genre_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id, string $name)
    {
        $genre = $this->genre_repository->find($id);
        if (!$genre) {
            throw new Exception("Genre tidak ditemukan");
        }
        if ($name == $genre->getName()) {
            throw new Exception("Genre tidak berubah");
        }

        $check_genre = $this->genre_repository->findByName($name);
        if ($check_genre) {
            throw new Exception("Genre sudah ada");
        }
        $input = Genre::create(
            $genre->getId(),
            $name
        );
        $this->genre_repository->persist($input);
    }
}
