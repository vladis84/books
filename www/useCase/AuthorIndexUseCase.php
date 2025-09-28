<?php

declare(strict_types=1);

namespace app\useCase;

use app\repository\AuthorRepository;
use app\request\AuthorIndexRequest;
use app\request\BaseRequest;
use yii\data\ActiveDataProvider;

readonly class AuthorIndexUseCase implements UseCaseInterface
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    /**
     * @param AuthorIndexRequest $request
     * @return mixed
     */
    public function execute(BaseRequest $request): ActiveDataProvider
    {
        return $this->authorRepository->findAll($request->getAttributes(), 50);
    }
}
