<?php

use yii\db\Migration;

class m250928_090317_add_user_token extends Migration
{

    public function safeUp(): void
    {
        $this->createTable(
            '{{%user_token}}',
            [
                'user_id' => $this->integer(),
                'token' => $this->string(50),
                'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
                'expired_at' => $this->dateTime()->notNull(),
            ]
        );
        $this->addForeignKey(
            'user_token_user_id',
            'user_token',
            'user_id',
            'user',
            'id'
        );
    }

    public function safeDown(): void
    {
        $this->dropTable('{{%user_token}}');
    }
}
