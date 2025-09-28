<?php

declare(strict_types=1);

namespace app\components;

class Controller extends \yii\rest\Controller
{
    public function runAction($id, $params = [])
    {
        $result = parent::runAction($id, $params);

        $result['success'] = true;

        return $result;
    }
}
