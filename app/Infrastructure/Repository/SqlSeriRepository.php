<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Seri\Seri;
use Exception;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class SqlSeriRepository
{
    public function persist(Seri $seri): void
    {
        DB::table('seri')->upsert([
            'id' => $seri->getId(),
            'penerbit_id' => $seri->getPenerbitId(),
            'judul' => $seri->getJudul(),
            'sinopsis' => $seri->getSinopsis(),
            'tahun_terbit' => $seri->getTahunTerbit(),
            'skor' => $seri->getSkor(),
            'foto' => $seri->getFoto(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Seri
    {
        $row = DB::table('seri')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getAll(int $page, int $per_page, ?string $search, ?array $filter): array
    {
        $rows = DB::table('seri')
            ->leftJoin('seri_genre', 'seri.id', '=', 'seri_genre.seri_id')
            ->leftJoin('genre', 'seri_genre.genre_id', '=', 'genre.id')
            ->select('seri.*')
            ->groupBy('seri.id');
        if ($filter) {
            $rows->where('genre.id', $filter);
        }
        if ($search) {
            $rows->where('seri.judul', 'like', '%' . $search . '%');
        }

        $rows = $rows->paginate($per_page, ['*'], 'seri_page', $page);
        $seris = [];
        foreach ($rows as $row) {
            $seris[] = $this->constructFromRows([$row])[0];
        }

        return [
            "data" => $seris,
            "max_page" => ceil($rows->total() / $per_page)
        ];
    }

    public function getLastSeriId()
    {
        $row = DB::table('seri')->orderBy('id', 'desc')->first();
        return $row->id;
    }

    public function delete(int $id): void
    {
        DB::table('seri_genre')->where('seri_id', $id)->delete();
        DB::table('seri_penulis')->where('seri_id', $id)->delete();
        DB::table('volume')->where('seri_id', $id)->delete();
        DB::table('seri')->where('id', $id)->delete();
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $seri = [];
        foreach ($rows as $row) {
            $seri[] = new Seri(
                $row->id,
                $row->penerbit_id,
                $row->judul,
                $row->sinopsis,
                $row->tahun_terbit,
                $row->skor,
                $row->foto,
            );
        }
        return $seri;
    }
}
