<?php

namespace App\Core\Domain\Models\Genre;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    private int $id;
    private string $nama;

    /**
     * @param int $id
     * @param string $nama
     */
    public function __construct(int $id, string $nama)
    {
        $this->id = $id;
        $this->nama = $nama;
    }

    public static function create(int $id, string $nama)
    {
        return new self(
            $id,
            $nama
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNama(): string
    {
        return $this->nama;
    }
}
