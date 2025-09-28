<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\Controller;
use app\request\LoginRequest;
use app\useCase\LoginUseCase;
use yii\filters\AccessControl;

class AuthController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['login'],
                    'roles' => ['?', '@'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actionLogin(): array
    {
        $request = \Yii::$container->get(LoginRequest::class, ['attributes' => \Yii::$app->request->post()]);
        $request->validate();
        $useCase = \Yii::$container->get(LoginUseCase::class);

        return ['code' => $useCase->execute($request)];
    }
}
