<?php

namespace App\Core\Domain\Models\Kabupaten;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    private int $id;
    private int $provinsi_id;
    private string $name;

    /**
     * @param int $id
     * @param int $provinsi_id
     * @param string $name
     */
    public function __construct(int $id, int $provinsi_id, string $name)
    {
        $this->id = $id;
        $this->provinsi_id = $provinsi_id;
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
     * @return int
     */
    public function getProvinsiId(): int
    {
        return $this->provinsi_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
