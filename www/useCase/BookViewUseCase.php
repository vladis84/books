<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Book;
use app\repository\BookRepository;
use app\request\BaseRequest;
use app\request\BookViewRequest;
use yii\web\NotFoundHttpException;

readonly class BookViewUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    /**
     * @param BookViewRequest $request
     * @return Book
     */
    public function execute(BaseRequest $request): Book
    {
        $book = $this->bookRepository->findOne(['id' => $request->id]);
        if ($book === null) {
            throw new NotFoundHttpException('Book not found');
        }

        return $book;
    }
}
