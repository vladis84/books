<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Book;
use app\repository\BookRepository;
use app\request\BaseRequest;
use app\request\BookCreateRequest;

readonly class BookCreateUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository)
    {
    }

    /**
     * @param BookCreateRequest $request
     * @return Book
     */
    public function execute(BaseRequest $request): Book
    {
        $prevBook = $this->bookRepository->findOne(['ibsn' => $request->isbn]);
        if ($prevBook === null) {
            throw new \LogicException("Книга с ibsn '{$request->isbn}' уже существует");
        }

        $book = new Book(['attributes' => $request->getAttributes()]);
        if (!$this->bookRepository->save($book)) {
            throw new \LogicException('Book not saved');
        }

        return $book;
    }
}
