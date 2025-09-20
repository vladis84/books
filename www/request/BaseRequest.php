<?php

declare(strict_types=1);

namespace app\request;

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
}
