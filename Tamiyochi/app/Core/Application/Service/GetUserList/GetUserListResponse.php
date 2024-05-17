<?php

namespace App\Core\Application\Service\GetUserList;

use JsonSerializable;
use App\Core\Domain\Models\User\User;

class GetUserListResponse implements JsonSerializable
{
    public User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId()->toString(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()->toString(),
            'no_telp' => $this->user->getNoTelp(),
            'user_type' => $this->user->getUserType()->value,
            'age' => $this->user->getAge(),
            'image_url' => $this->user->getImageUrl(),
        ];
    }
}
