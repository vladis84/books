<?php

declare(strict_types=1);

namespace app\exceptions;

use yii\base\UserException;

class ValidationException extends UserException
{
    private array $errors = [];

    public function __construct(array $errors = [], ?string $message = null, int $code = 0, ?UserException $previous = null)
    {
        if (is_null($message)) {
            $message = 'Некорректные данные';
        }

        if (!empty($errors)) {
            foreach ($errors as $name => $error) {
                if (is_array($error)) {
                    $errors[$name] = reset($error);
                }
            }
            $this->errors = $errors;
        }

        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
