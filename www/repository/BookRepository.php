<?php

declare(strict_types=1);

namespace app\repository;

use app\models\Book;
use yii\data\ActiveDataProvider;

class BookRepository
{
    public function findAll(int $pageSize): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Book::find(),

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

    public function findOne(array $condition): ?Book
    {
        return Book::findOne($condition);
    }

    public function save(Book $book): bool
    {
        return $book->save();
    }
}
