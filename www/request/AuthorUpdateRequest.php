<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property int $id
 */
class AuthorUpdateRequest extends AuthorCreateRequest
{
    protected function prepareAttributes(array $attributes): array
    {
        $attributes = parent::prepareAttributes($attributes);
        $attributes['id'] = $attributes['id'] ?? null;

        return $attributes;
    }

    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = ['id', 'integer'];
        $rules[] = ['id', 'required'];

        return $rules;
    }
}
