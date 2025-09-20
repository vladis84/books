<?php

namespace app\useCase;

use app\request\BaseRequest;

interface UseCaseInterface
{
    public function execute(BaseRequest $request): mixed;
}
