<?php

declare(strict_types=1);

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $username
 * @property string $password
 */
class Identity extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'user';
    }
}
