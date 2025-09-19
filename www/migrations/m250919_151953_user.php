<?php

use yii\db\Migration;

class m250919_151953_user extends Migration
{

    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'password' => $this->string()->notNull(),
        ]);

        $this->insert('user', [
            'username' => 'admin',
            'password' => Yii::$app->getSecurity()->generatePasswordHash('admin'),
        ]);
    }


    public function safeDown()
    {
        $this->dropTable('user');
    }
}
