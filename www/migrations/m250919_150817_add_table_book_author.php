<?php

use yii\db\Migration;

class m250919_150817_add_table_book_author extends Migration
{
    public function safeUp(): void
    {
        $this->createTable('book_author', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('book_author_books_pk', 'book_author', ['book_id', 'author_id']);

        $this->addForeignKey(
            'book_author_book_id',
            'book_author',
            'book_id',
            'book',
            'id'
        );
        $this->addForeignKey(
            'book_author_author_id',
            'book_author',
            'author_id',
            'author',
            'id'
        );
    }

    public function safeDown(): void
    {
        $this->dropTable('book_author');
    }
}
