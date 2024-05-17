<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Volume\Volume;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlVolumeRepository
{
    public function persist(Volume $volume): void
    {
        DB::table('volume')->upsert([
            'id' => $volume->getId(),
            'seri_id' => $volume->getSeriId(),
            'volume' => $volume->getVolume(),
            'jumlah_tersedia' => $volume->getJumlahTersedia(),
            'harga_sewa' => $volume->getHargaSewa(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(int $id): ?Volume
    {
        $row = DB::table('volume')->where('id', $id)->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getVolumeBySeriId(int $seri_id): array
    {
        $rows = DB::table('volume')->where('seri_id', $seri_id)->get();
        $volume = [];
        foreach ($rows as $row) {
            $volume[] = $this->constructFromRows([$row])[0];
        }
        return $volume;
    }

    public function getVolumeById(int $id): ?Volume
    {
        $row = DB::table('volume')->where('id', $id)->first();
        if (!$row) {
            return null;
        }
        return $this->constructFromRows([$row])[0];
    }

    public function getLastVolumeId(): int
    {
        $row = DB::table('volume')->orderBy('id', 'desc')->first();
        if (!$row) {
            return 0;
        }
        return $row->id;
    }

    public function deleteBySeriId(string $seri_id): void
    {
        DB::table('volume')->where('seri_id', $seri_id)->delete();
    }

    public function decrementJumlahTersedia(int $id): void 
    {
        DB::table('volume')->where('id', $id)->decrement('jumlah_tersedia');
    }

    public function incrementJumlahTersedia(int $id): void 
    {
        DB::table('volume')->where('id', $id)->increment('jumlah_tersedia');
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $volume = [];
        foreach ($rows as $row) {
            $volume[] = new Volume(
                $row->id,
                $row->seri_id,
                $row->volume,
                $row->jumlah_tersedia,
                $row->harga_sewa,
            );
        }
        return $volume;
    }
}
