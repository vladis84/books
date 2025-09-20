<?php

declare(strict_types=1);

namespace app\useCase;

use app\repository\BookRepository;
use app\request\BaseRequest;
use app\request\BookUpdateRequest;
use yii\web\NotFoundHttpException;

readonly class BookUpdateUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    /**
     * @param BookUpdateRequest $request
     * @return mixed
     */
    public function execute(BaseRequest $request): int
    {
        $book = $this->bookRepository->findOne(['id' => $request->id]);
        if ($book === null) {
            throw new NotFoundHttpException();
        }

        $book->name = $request->name;
        $book->description = $request->description;
        $book->isbn = $request->isbn;
        if (!$this->bookRepository->save($book)) {
            throw new \LogicException('Book not saved');
        }

        return $book->id;
    }
}
