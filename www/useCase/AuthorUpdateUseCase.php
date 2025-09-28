<?php

declare(strict_types=1);

namespace app\useCase;

use app\models\Author;
use app\repository\AuthorRepository;
use app\request\AuthorUpdateRequest;
use app\request\BaseRequest;

readonly class AuthorUpdateUseCase implements UseCaseInterface
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    /**
     * @param AuthorUpdateRequest $request
     * @return mixed
     */
    public function execute(BaseRequest $request): Author
    {
        $author = $this->authorRepository->findOne(['id' => $request['id']]);
        if ($author === null) {
            throw new \LogicException('Author was not found.');
        }

        $author->attributes = $request->getAttributes();
        $this->authorRepository->save($author);

        return $author;
    }
}
