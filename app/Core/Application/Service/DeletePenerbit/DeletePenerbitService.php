<?php

namespace App\Core\Application\Service\DeletePenerbit;

use Exception;
use App\Infrastructure\Repository\SqlPenerbitRepository;

class DeletePenerbitService
{
    private SqlPenerbitRepository $penerbit_repository;

    public function __construct(SqlPenerbitRepository $penerbit_repository)
    {
        $this->penerbit_repository = $penerbit_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $penerbit_id)
    {
        $this->penerbit_repository->delete($penerbit_id);
    }
}
