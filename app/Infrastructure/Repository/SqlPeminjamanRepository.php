<?php

namespace App\Infrastructure\Repository;

use App\Core\Domain\Models\Peminjaman\Peminjaman;
use App\Core\Domain\Models\Peminjaman\PeminjamanId;
use App\Core\Domain\Models\User\UserId;
use Exception;
use Illuminate\Support\Facades\DB;

class SqlPeminjamanRepository
{
    public function persist(Peminjaman $peminjaman): void
    {
        DB::table('peminjaman')->upsert([
            'id' => $peminjaman->getId()->toString(),
            'user_id' => $peminjaman->getUserId()->toString(),
            'paid_at' => $peminjaman->getPaidAt(),
            'invoice_url' => $peminjaman->getInvoiceUrl(),
            'status' => $peminjaman->getStatus(),
            'jumlah' => $peminjaman->getJumlah(),
            'harga_total' => $peminjaman->getHargaTotal(),
        ], 'id');
    }

    /**
     * @throws Exception
     */
    public function find(PeminjamanId $id): ?Peminjaman
    {
        $row = DB::table('peminjaman')->where('id', $id->toString())->first();

        if (!$row) {
            return null;
        }

        return $this->constructFromRows([$row])[0];
    }

    /**
     * @throws Exception
     */
    public function getAllPeminjaman(string $status): array
    {
        $rows = DB::table('peminjaman')->where('status', $status)->get();

        $peminjamans = [];
        foreach ($rows as $row) {
            $peminjamans[] = $this->constructFromRows([$row])[0];
        }

        return $peminjamans;
    }

    /**
     * @throws Exception
     */
    public function getAllPeminjamanByUserId(string $user_id): array
    {
        $rows = DB::table('peminjaman')->where('user_id', $user_id)->get();

        $peminjamans = [];
        foreach ($rows as $row) {
            $peminjamans[] = $this->constructFromRows([$row])[0];
        }

        return $peminjamans;
    }

    /**
     * @throws Exception
     */
    public function constructFromRows(array $rows): array
    {
        $peminjaman = [];
        foreach ($rows as $row) {
            $peminjaman[] = new Peminjaman(
                new PeminjamanId($row->id),
                new UserId($row->user_id),
                $row->paid_at,
                $row->invoice_url,
                $row->status,
                $row->jumlah,
                $row->harga_total,
            );
        }
        return $peminjaman;
    }
}
