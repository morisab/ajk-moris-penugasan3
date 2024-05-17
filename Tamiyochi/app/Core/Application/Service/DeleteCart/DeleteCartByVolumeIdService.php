<?php

namespace App\Core\Application\Service\DeleteCart;

use Exception;
use App\Core\Domain\Models\Cart\CartId;
use App\Core\Domain\Models\User\UserId;
use App\Infrastructure\Repository\SqlCartRepository;

class DeleteCartByVolumeIdService
{
    private SqlCartRepository $cart_repository;

    public function __construct(SqlCartRepository $cart_repository)
    {
        $this->cart_repository = $cart_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(string $volume_id, string $user_id)
    {
        $check_cart = $this->cart_repository->findByVolumeIdAndUserId($volume_id, new UserId($user_id));
        if (!$check_cart) {
            throw new Exception("Cart tidak ditemukan");
        }

        $this->cart_repository->deleteByVolumeId($volume_id);
    }
}
