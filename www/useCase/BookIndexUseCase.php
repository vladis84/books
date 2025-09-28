<?php

declare(strict_types=1);

namespace app\useCase;

use app\repository\BookRepository;
use app\request\BaseRequest;
use yii\data\ActiveDataProvider;

readonly class BookIndexUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    public function execute(BaseRequest $request): ActiveDataProvider
    {
        return $this->bookRepository->findAll($request->getAttributes(), 50);
    }
}
