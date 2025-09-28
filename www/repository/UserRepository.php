<?php

declare(strict_types=1);

namespace app\repository;

use app\models\User;

class UserRepository
{
    public function findByUsername(string $username): ?User
    {
        return User::findByUsername($username);
    }
}
