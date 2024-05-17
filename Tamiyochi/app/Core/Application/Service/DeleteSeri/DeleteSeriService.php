<?php

namespace App\Core\Application\Service\DeleteSeri;

use Exception;
use App\Infrastructure\Repository\SqlSeriRepository;

class DeleteSeriService
{
    private SqlSeriRepository $seri_repository;

    public function __construct(SqlSeriRepository $seri_repository)
    {
        $this->seri_repository = $seri_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(int $seri_id)
    {
        $this->seri_repository->delete($seri_id);
    }
}
