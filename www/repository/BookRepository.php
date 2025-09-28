<?php

declare(strict_types=1);

namespace app\repository;

use app\models\Book;
use yii\data\ActiveDataProvider;

class BookRepository
{
    public function findAll(array $conditions, int $pageSize): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Book::find()->joinWith(['authors'])->where($conditions),

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

    public function clearAuthorsIds(Book $book): void
    {
        \Yii::$app->db
            ->createCommand()
            ->delete('book_author', 'book_id = :bookId', [':bookId' => $book->id])
            ->execute();
    }

    public function addAuthorsIds(Book $book, array $authorsIds): void
    {
        $rows = array_map(
            static fn($authorId) => [$book->id, (int)$authorId],
            $authorsIds
        );
        \Yii::$app->db->createCommand()->batchInsert(
            '{{%book_author}}',
            ['book_id', 'author_id'],
            $rows
        )->execute();
    }
}
