<?php

namespace App\Core\Application\Service\GetUserList;

use App\Infrastructure\Repository\SqlUserRepository;
use Exception;

class GetUserListService
{
    private SqlUserRepository $user_repository;

    /**
     * @param SqlUserRepository $user_repository
     */
    public function __construct(SqlUserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        $list_user = $this->user_repository->getAll();

        $response = [];
        foreach ($list_user as $user) {
            $response[] = new GetUserListResponse($user);
        }

        return $response;
    }
}
