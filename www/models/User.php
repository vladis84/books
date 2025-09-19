<?php

namespace app\models;

use yii\base\NotSupportedException;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public int $id;

    public string $username;

    public string $password;

    public string $authKey = '';

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): ?static
    {
        $identity = Identity::findOne($id);

        return new static($identity->getAttributes());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username): ?static
    {
        $identity = Identity::findOne(['username' => $username]);

        return new static($identity->getAttributes());
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password): bool
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
