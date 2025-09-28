<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Author;
use app\repository\AuthorRepository;
use app\request\AuthorCreateRequest;
use app\request\BaseRequest;

readonly class AuthorCreateUseCase implements UseCaseInterface
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    /**
     * @param AuthorCreateRequest $request
     * @return mixed
     */
    public function execute(BaseRequest $request): Author
    {
        $author = new Author();
        $author->name = $request->name;

        if (!$this->authorRepository->save($author)) {
            throw new \LogicException('Author not saved');
        }

        return $author;
    }
}
