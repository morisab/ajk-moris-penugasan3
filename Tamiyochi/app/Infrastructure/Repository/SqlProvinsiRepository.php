<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Provinsi\Provinsi;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlProvinsiRepository
{
    public function persist(Provinsi $provinsi): void
    {
        DB::table('provinsi')->upsert([
            'id' => $provinsi->getId(),
            'name' => $provinsi->getName(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Provinsi
    {
        $row = DB::table('provinsi')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $provinsi = [];
        foreach ($rows as $row) {
            $provinsi[] = new Provinsi(
                $row->id,
                $row->name,
            );
        }
        return $provinsi;
    }
}
