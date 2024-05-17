<?php

namespace App\Infrastructure\Repository;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Core\Domain\Models\User\UserId;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolume;
use App\Core\Domain\Models\PeminjamanVolume\PeminjamanVolumeId;

class SqlPeminjamanVolumeRepository
{
    public function persist(PeminjamanVolume $peminjaman_volume): void
    {
        DB::table('peminjaman_volume')->upsert([
            'id' => $peminjaman_volume->getId()->toString(),
            'peminjaman_id' => $peminjaman_volume->getPeminjamanId()->toString(),
            'volume_id' => $peminjaman_volume->getVolumeId(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(PeminjamanVolumeId $id): ?PeminjamanVolume
    {
        $row = DB::table('peminjaman_volume')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    public function getAllPeminjamanVolumeByPeminjamanId(PeminjamanId $peminjaman_id): array
    {
        $rows = DB::table('peminjaman_volume')->where('peminjaman_id', $peminjaman_id->toString())->get();
        
        $peminjaman_volumes = [];
        foreach ($rows as $row) {
            $peminjaman_volumes[] = $this->constructFromRows([$row])[0];
        }
        return $peminjaman_volumes;
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $peminjaman_volume = [];
        foreach ($rows as $row) {
            $peminjaman_volume[] = new PeminjamanVolume(
                new PeminjamanVolumeId($row->id),
                new PeminjamanId($row->peminjaman_id),
                $row->volume_id,
            );
        }
        return $peminjaman_volume;
    }
}
