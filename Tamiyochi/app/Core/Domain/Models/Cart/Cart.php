<?php

namespace App\Core\Domain\Models\Cart;

use App\Core\Domain\Models\User\UserId;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    private CartId $id;
    private UserId $user_id;
    private int $volume_id;

    /**
     * @param CartId $id
     * @param UserId $user_id
     * @param int $volume_id
     */
    public function __construct(CartId $id, UserId $user_id, int $volume_id)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->volume_id = $volume_id;
    }

    public static function create(UserId $user_id, int $volume_id)
    {
        return new self(
            CartId::generate(),
            $user_id,
            $volume_id
        );
    }

    public function getId(): CartId
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->user_id;
    }

    public function getVolumeId(): int
    {
        return $this->volume_id;
    }
    
}
