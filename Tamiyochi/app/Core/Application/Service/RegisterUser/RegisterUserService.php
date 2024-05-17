<?php

namespace App\Core\Application\Service\RegisterUser;

use Exception;
use App\Core\Domain\Models\Email;
use App\Exceptions\UserException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Core\Domain\Models\User\User;
use App\Core\Domain\Models\User\UserType;
use App\Core\Application\ImageUpload\ImageUpload;
use App\Core\Application\Mail\AccountVerificationEmail;
use App\Core\Domain\Models\AccountVerification\AccountVerification;
use App\Core\Domain\Repository\AccountVerificationRepositoryInterface;
use App\Infrastructure\Repository\SqlUserRepository;

class RegisterUserService
{
    private SqlUserRepository $user_repository;

    /**
     * @param SqlUserRepository $user_repository
     * @param AccountVerificationRepositoryInterface $account_verification_repository
     */
    public function __construct(SqlUserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }

    /**
     * @throws Exception
     */
    public function execute(RegisterUserRequest $request)
    {
        $registeredUser = $this->user_repository->findByEmail($request->getEmail());
        if ($registeredUser) {
            UserException::throw("email sudah terdaftar", 1022, 404);
        }

        $image_url = ImageUpload::create(
            $request->getImage(),
            'images',
            $request->getEmail(),
            'profile'
        )->upload();

        $user = User::create(
            1101,
            $request->getName(),
            new Email($request->getEmail()),
            $request->getNoTelp(),
            UserType::USER,
            $request->getAge(),
            $image_url,
            $request->getPassword()
        );
        $this->user_repository->persist($user);
    }
}
