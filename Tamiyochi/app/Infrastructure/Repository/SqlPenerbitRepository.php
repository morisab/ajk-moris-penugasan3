<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Penerbit\Penerbit;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlPenerbitRepository
{
    public function persist(Penerbit $penerbit): void
    {
        DB::table('penerbit')->upsert([
            'id' => $penerbit->getId(),
            'nama' => $penerbit->getNama(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Penerbit
    {
        $row = DB::table('penerbit')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function findByName(string $nama): ?Penerbit
    {
        $row = DB::table('penerbit')->where('nama', $nama)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getLastPenerbitId(): int
    {
        $row = DB::table('penerbit')->orderBy('id', 'desc')->first();
        if (!$row) {
            return 0;
        }
        return $row->id;
    }

    public function getAll(): array
    {
        $rows = DB::table('penerbit')->get();
        return $rows->toArray();
    }

    public function delete(int $id): void
    {
        DB::table('penerbit')->where('id', $id)->delete();
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $penerbit = [];
        foreach ($rows as $row) {
            $penerbit[] = new Penerbit(
                $row->id,
                $row->nama,
            );
        }
        return $penerbit;
    }
}
