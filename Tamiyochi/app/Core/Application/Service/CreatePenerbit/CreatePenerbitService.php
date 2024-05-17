<?php

namespace App\Core\Application\Service\CreatePenerbit;

use Exception;
use App\Core\Domain\Models\Penerbit\Penerbit;
use App\Infrastructure\Repository\SqlPenerbitRepository;

class CreatePenerbitService
{
    private SqlPenerbitRepository $penerbit_repository;

    public function __construct(SqlPenerbitRepository $penerbit_repository)
    {
        $this->penerbit_repository = $penerbit_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $name)
    {
        $check_penerbit = $this->penerbit_repository->findByName($name);
        if ($check_penerbit) {
            throw new Exception("Penerbit sudah ada");
        }
        $penerbit_id = $this->penerbit_repository->getLastPenerbitId();
        $input = Penerbit::create(
            $penerbit_id + 1,
            $name
        );
        $this->penerbit_repository->persist($input);
    }
}
