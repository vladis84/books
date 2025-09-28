<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\UserToken;
use app\repository\UserRepository;
use app\repository\UserTokenRepository;
use app\request\BaseRequest;
use app\request\LoginRequest;
use yii\web\UnauthorizedHttpException;

readonly class LoginUseCase implements UseCaseInterface
{
    public function __construct(private UserRepository $userRepository, private UserTokenRepository $tokenRepository)
    {
    }

    /**
     * @param LoginRequest $request
     */
    public function execute(BaseRequest $request): string
    {
        $user = $this->userRepository->findByUsername($request->username);
        if ($user === null) {
            throw new UnauthorizedHttpException();
        }

        if (!$user->validatePassword($request->password)) {
            throw new UnauthorizedHttpException();
        }

        $userToken = $this->getUserToken($user->id);

        return $userToken->token;
    }

    private function getUserToken(int $userId): UserToken
    {
        $token = $this->tokenRepository->findOne(['user_id' => $userId]);
        if ($token?->isActive()) {
            return $token;
        }

        $userToken = new UserToken();
        $userToken->user_id = $userId;
        $userToken->token = bin2hex(random_bytes(20));
        $userToken->expired_at = date('Y-m-d H:i:s', strtotime('+1 Day'));
        $this->tokenRepository->save($userToken);

        return $userToken;
    }
}
