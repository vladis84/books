<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Book;
use app\repository\AuthorRepository;
use app\repository\BookRepository;
use app\request\BaseRequest;
use app\request\BookUpdateRequest;
use yii\web\NotFoundHttpException;

readonly class BookUpdateUseCase implements UseCaseInterface
{
    public function __construct(private BookRepository $bookRepository, private AuthorRepository $authorRepository)
    {
    }

    /**
     * @param BookUpdateRequest $request
     * @return mixed
     */
    public function execute(BaseRequest $request): Book
    {
        $book = $this->bookRepository->findOne(['id' => $request->id]);
        if ($book === null) {
            throw new NotFoundHttpException();
        }

        $authors = $this->authorRepository->findMany(['id' => $request->authorsIds]);
        if (count($authors) !== count($request->authorsIds)) {
            throw new \LogicException('Найдены не все авторы');
        }

        return \Yii::$app->db->transaction(function () use ($book, $request): Book {
            $book->name = $request->name;
            $book->description = $request->description;
            $book->isbn = $request->isbn;

            if (!$this->bookRepository->save($book)) {
                throw new \LogicException('Book not saved');
            }

            $this->bookRepository->clearAuthorsIds($book);

            $this->bookRepository->addAuthorsIds($book, $request->authorsIds);

            return $book;
        });
    }
}
