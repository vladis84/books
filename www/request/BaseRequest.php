<?php

declare(strict_types=1);

namespace app\request;

use yii\base\UserException;

class BaseRequest extends \yii\base\DynamicModel
{
    public function init(): void
    {
        if (!$this->validate()) {
            throw new UserException();
        }
    }
}
