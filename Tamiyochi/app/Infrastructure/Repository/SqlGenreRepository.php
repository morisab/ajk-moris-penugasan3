<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Genre\Genre;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlGenreRepository
{
    public function persist(Genre $genre): void
    {
        DB::table('genre')->upsert([
            'id' => $genre->getId(),
            'nama' => $genre->getNama(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Genre
    {
        $row = DB::table('genre')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getGenreBySeriId(int $seri_id): array
    {
        $rows = DB::table('genre')
            ->leftJoin('seri_genre', 'genre.id', '=', 'seri_genre.genre_id')
            ->where('seri_genre.seri_id', $seri_id)
            ->select('genre.*')
            ->get();
        $genre = [];
        foreach ($rows as $row) {
            $genre[] = $this->constructFromRows([$row])[0];
        }
        return $genre;
    }

    public function getAll(): array
    {
        $rows = DB::table('genre')->get();
        return $rows->toArray();
    }

    public function getLastGenreId(): int
    {
        $row = DB::table('genre')->orderBy('id', 'desc')->first();
        if (!$row) {
            return 0;
        }
        return $row->id;
    }

    public function findByName(string $name): ?Genre
    {
        $row = DB::table('genre')->where('nama', $name)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function delete(int $id): void
    {
        DB::table('genre')->where('id', $id)->delete();
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $genre = [];
        foreach ($rows as $row) {
            $genre[] = new Genre(
                $row->id,
                $row->nama,
            );
        }
        return $genre;
    }
}
