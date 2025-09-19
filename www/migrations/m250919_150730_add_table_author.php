<?php

use yii\db\Migration;

class m250919_150730_add_table_author extends Migration
{

    public function safeUp(): void
    {
        $this->createTable('author', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }


    public function safeDown(): void
    {
        $this->dropTable('author');
    }
}
