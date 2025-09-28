<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property string $name
 * @property string $isbn
 * @property string $description
 * @property int $authorsIds
 */
class BookCreateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name', 'isbn'], 'required'],
            [['name', 'description', 'isbn'], 'string', 'max' => 255],
        ];
    }

    protected function prepareAttributes(array $attributes): array
    {
        return [
            'name' => $attributes['name'] ?? null,
            'description' => $attributes['description'] ?? null,
            'isbn' => $attributes['isbn'] ?? null,
            'authorsIds' => $attributes['authorsIds'] ?? [],
        ];
    }
}
