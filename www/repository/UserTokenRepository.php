<?php

declare(strict_types=1);

namespace app\repository;

use app\models\UserToken;

class UserTokenRepository
{
    public function findOne(array $conditions): ?UserToken
    {
        return UserToken::findOne($conditions);
    }

    public function save(UserToken $userToken): bool
    {
        return $userToken->save();
    }
}
