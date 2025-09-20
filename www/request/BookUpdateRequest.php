<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property int $id
 * @inheritDoc
 */
class BookUpdateRequest extends BookCreateRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules[] = [['id'], 'required'];
        $rules[] = [['id'], 'integer'];

        return $rules;
    }

    protected function prepareAttributes(array $attributes): array
    {
         $attributes = parent::prepareAttributes($attributes);
         $attributes['id'] = $attributes['id'] ?? null;
         return $attributes;
    }
}
