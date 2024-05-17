<?php

use App\Infrastructure\Repository\SqlUserRepository;
use App\Core\Domain\Repository\UserRepositoryInterface;

/** @var Application $app */

$app->singleton(UserRepositoryInterface::class, SqlUserRepository::class);
