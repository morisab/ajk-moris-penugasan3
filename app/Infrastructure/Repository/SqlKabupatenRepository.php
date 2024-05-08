<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Kabupaten\Kabupaten;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlKabupatenRepository
{
    public function persist(Kabupaten $kabupaten): void
    {
        DB::table('kabupaten')->upsert([
            'id' => $kabupaten->getId(),
            'name' => $kabupaten->getName(),
            'provinsi_id' => $kabupaten->getProvinsiId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Kabupaten
    {
        $row = DB::table('kabupaten')->where('id', $id)->first();

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
        $kabupaten = [];
        foreach ($rows as $row) {
            $kabupaten[] = new Kabupaten(
                $row->id,
                $row->name,
                $row->provinsi_id,
            );
        }
        return $kabupaten;
    }
}
