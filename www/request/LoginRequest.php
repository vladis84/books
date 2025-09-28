<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property string $username
 * @property string $password
 */
class LoginRequest extends BaseRequest
{
    protected function prepareAttributes(array $attributes): array
    {
        return [
            'username' => $attributes['username'] ?? null,
            'password' => $attributes['password'] ?? null,
        ];
    }

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
        ];
    }
}
