<?php

namespace App\Core\Application\Service\UpdatePenulis;

use Exception;
use App\Core\Domain\Models\Penulis\Penulis;
use App\Infrastructure\Repository\SqlPenulisRepository;

class UpdatePenulisService
{
    private SqlPenulisRepository $penulis_repository;

    public function __construct(SqlPenulisRepository $penulis_repository)
    {
        $this->penulis_repository = $penulis_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $id, string $nama_depan, string $nama_belakang, string $peran)
    {
        $penulis = $this->penulis_repository->find($id);
        if (!$penulis) {
            throw new Exception("Penulis tidak ditemukan");
        }
        if ($nama_depan == $penulis->getNamaDepan() && $nama_belakang == $penulis->getNamaBelakang() && $peran == $penulis->getPeran()) {
            throw new Exception("Penulis tidak berubah");
        }
        $check_penulis = $this->penulis_repository->findByName($nama_depan, $nama_belakang);
        if ($check_penulis) {
            throw new Exception("Penulis sudah ada");
        }
        $penulis_id = $this->penulis_repository->getLastPenulisId();
        $input = Penulis::create(
            $penulis_id + 1,
            $nama_depan,
            $nama_belakang,
            $peran
        );
        $this->penulis_repository->persist($input);
    }
}
