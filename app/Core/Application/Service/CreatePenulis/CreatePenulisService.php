<?php

namespace App\Core\Application\Service\CreatePenulis;

use Exception;
use App\Core\Domain\Models\Penulis\Penulis;
use App\Infrastructure\Repository\SqlPenulisRepository;

class CreatePenulisService
{
    private SqlPenulisRepository $penulis_repository;

    public function __construct(SqlPenulisRepository $penulis_repository)
    {
        $this->penulis_repository = $penulis_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $nama_depan, string $nama_belakang, string $peran)
    {
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
