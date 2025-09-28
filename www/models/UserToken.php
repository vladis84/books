<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $user_id
 * @property string $token
 * @property string $created_at
 * @property string $expired_at
 * @property User $user
 */
class UserToken extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%user_token}}';
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function isActive(): bool
    {
        $expiredAt = new \DateTime($this->expired_at);
        $currentDateTime = \Yii::$container->get('currentDateTime');

        return $expiredAt > $currentDateTime;
    }
}
