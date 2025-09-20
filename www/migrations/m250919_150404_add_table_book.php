<?php

use yii\db\Migration;

class m250919_150404_add_table_book extends Migration
{

    public function safeUp(): void
    {
        $this->createTable(
            'book',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string()->notNull(),
                'description' => $this->string(),
                'isbn' => $this->string()->notNull()->unique(),
            ]
        );
    }

    public function safeDown(): void
    {
        $this->dropTable('book');
    }
}
