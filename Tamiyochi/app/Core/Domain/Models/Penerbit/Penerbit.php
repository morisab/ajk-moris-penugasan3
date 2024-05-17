<?php

namespace App\Core\Domain\Models\Penerbit;

use App\Core\Domain\Models\Seri\Seri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penerbit extends Model
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

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNama(): string
    {
        return $this->nama;
    }

    public function seri(): HasMany
    {
        return $this->hasMany(Seri::class);
    }
}
