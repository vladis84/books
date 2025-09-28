<?php

declare(strict_types=1);

namespace app\request;

use app\exceptions\ValidationException;

abstract class BaseRequest extends \yii\base\DynamicModel
{
    public function __construct(array $attributes = [], $config = [])
    {
        parent::__construct($this->prepareAttributes($attributes), $config);
    }

    protected function prepareAttributes(array $attributes): array
    {
        return $attributes;
    }

    public function validate($attributeNames = null, $clearErrors = true): bool
    {
        $result = parent::validate($attributeNames, $clearErrors);
        if (!$result) {
            throw new ValidationException($this->getErrors());
        }

        return $result;
    }
}
