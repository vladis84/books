<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Book;
use app\repository\BookRepository;
use app\request\BaseRequest;

readonly class BookCreateUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    public function execute(BaseRequest $request): Book
    {
        $book = new Book(['attributes' => $request->getAttributes()]);
        if (!$this->bookRepository->save($book)) {
            throw new \LogicException('Book not saved');
        }

        return $book;
    }
}
