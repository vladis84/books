<?php

declare(strict_types=1);

namespace app\repository;

use app\models\Author;
use yii\data\ActiveDataProvider;

class AuthorRepository
{
    public function findAll(array $conditions, int $pageSize): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Author::find()->joinWith(['books'])->where($conditions),

            'pagination' => [
                'pageSize' => $pageSize,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],

        ]);
    }

    /**
     * @return Author[]
     */
    public function findMany(array $conditions): array
    {
        return Author::findAll($conditions);
    }

    public function findOne(array $conditions): ?Author
    {
        return Author::findOne($conditions);
    }

    public function save(Author $author): bool
    {
        return $author->save();
    }
}
