<?php

namespace app\components;

use app\exceptions\ValidationException;

class WebErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * @param \Throwable $exception
     * @return array
     */
    protected function convertExceptionToArray($exception): array
    {
        $data = [];
        $data['success'] = false;
        if ($exception instanceof ValidationException) {
            $data['errors'] = $exception->getErrors();
        }
        $className = get_class($exception);
        $data['message'] = $exception->getMessage() ?: basename(str_replace('\\', '/', $className));

        return $data;
    }
}
