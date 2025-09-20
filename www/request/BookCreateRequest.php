<?php

declare(strict_types=1);

namespace app\request;

/**
 * @property string $name
 * @property string $isbn
 * @property string $description
 */
class BookCreateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            [['description'], 'default', 'value' => null],
            [['name', 'isbn'], 'required'],
            [['name', 'description', 'isbn'], 'string', 'max' => 10],
        ];
    }
}
