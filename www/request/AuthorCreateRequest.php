<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property string $name
 */
class AuthorCreateRequest extends BaseRequest
{
    protected function prepareAttributes(array $attributes): array
    {
        return ['name' => $attributes['name'] ?? null];
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
        ];
    }
}
