<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Book;
use app\repository\AuthorRepository;
use app\repository\BookRepository;
use app\request\BaseRequest;
use app\request\BookCreateRequest;

readonly class BookCreateUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository, private AuthorRepository $authorRepository)
    {
    }

    /**
     * @param BookCreateRequest $request
     * @return Book
     */
    public function execute(BaseRequest $request): Book
    {
        $prevBook = $this->bookRepository->findOne(['isbn' => $request->isbn]);
        if ($prevBook !== null) {
            throw new \LogicException("Книга с isbn '{$request->isbn}' уже существует");
        }

        $authors = $this->authorRepository->findMany(['id' => $request->authorsIds]);
        if (count($authors) !== count($request->authorsIds)) {
            throw new \LogicException('Найдены не все авторы');
        }

        return \Yii::$app->db->transaction(function () use ($request): Book {
            $book = new Book(['attributes' => $request->getAttributes()]);
            if (!$this->bookRepository->save($book)) {
                throw new \LogicException('Book not saved');
            }

            $this->bookRepository->addAuthorsIds($book, $request->authorsIds);

            return $book;
        });
    }
}
