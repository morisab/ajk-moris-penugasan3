<?php

namespace App\Core\Domain\Models\SeriGenre;

use Illuminate\Database\Eloquent\Model;

class SeriGenre extends Model
{
    private int $id;
    private int $seri_id;
    private int $genre_id;

    /**
     * @param int $id
     * @param int $seri_id
     * @param int $genre_id
     */
    public function __construct(int $id, int $seri_id, int $genre_id)
    {
        $this->id = $id;
        $this->seri_id = $seri_id;
        $this->genre_id = $genre_id;
    }

    public static function create(int $id, int $seri_id, int $genre_id)
    {
        return new self(
            $id,
            $seri_id,
            $genre_id
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSeriId(): int
    {
        return $this->seri_id;
    }

    public function getGenreId(): int
    {
        return $this->genre_id;
    }
}
