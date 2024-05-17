<?php

namespace App\Core\Domain\Models\Provinsi;

use App\Core\Domain\Models\Kabupaten\Kabupaten;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    private int $id;
    private string $name;

    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }

    public function kabupaten(): HasMany
    {
        return $this->hasMany(Kabupaten::class);
    }
}
