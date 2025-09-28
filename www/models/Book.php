<?php

namespace app\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $isbn
 *
 * @property Author[] $authors
 */
class Book extends \yii\db\ActiveRecord
{
    public function extraFields(): array
    {
        return ['authors'];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'book';
    }

    /**
     * Gets query for [[Authors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors(): ActiveQuery
    {
        return $this->hasMany(Author::class, ['id' => 'author_id'])
            ->viaTable('book_author', ['book_id' => 'id']);
    }
}
