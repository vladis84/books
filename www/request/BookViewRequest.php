<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property int $id
 */
class BookViewRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            ['id', 'integer'],
            ['id', 'required'],
        ];
    }

    protected function prepareAttributes(array $attributes): array
    {
        return [
            'id' => $attributes['id'] ?? null,
        ];
    }
}
