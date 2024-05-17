<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\SeriPenulis\SeriPenulis;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlSeriPenulisRepository
{
    public function persist(SeriPenulis $seri_penulis): void
    {
        DB::table('seri_penulis')->upsert([
            'id' => $seri_penulis->getId(),
            'seri_id' => $seri_penulis->getSeriId(),
            'penulis_id' => $seri_penulis->getPenulisId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?SeriPenulis
    {
        $row = DB::table('seri_penulis')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getLastSeriPenulisId(): int
    {
        $row = DB::table('seri_penulis')->orderBy('id', 'desc')->first();
        if (!$row) {
            return 0;
        }
        return $row->id;
    }

    public function deleteBySeriId(string $seri_id): void
    {
        DB::table('seri_penulis')->where('seri_id', $seri_id)->delete();
    }

    public function findFirst(string $seri_id): ?SeriPenulis
    {
        $row = DB::table('seri_penulis')->where('seri_id', $seri_id)->first();

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
        $seri_penulis = [];
        foreach ($rows as $row) {
            $seri_penulis[] = new SeriPenulis(
                $row->id,
                $row->seri_id,
                $row->penulis_id,
            );
        }
        return $seri_penulis;
    }
}
