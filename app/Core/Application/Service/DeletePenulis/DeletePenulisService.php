<?php

namespace App\Core\Application\Service\DeletePenulis;

use Exception;
use App\Infrastructure\Repository\SqlPenulisRepository;

class DeletePenulisService
{
    private SqlPenulisRepository $penulis_repository;

    public function __construct(SqlPenulisRepository $penulis_repository)
    {
        $this->penulis_repository = $penulis_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $penulis_id)
    {
        $this->penulis_repository->delete($penulis_id);
    }
}
