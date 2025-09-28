<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\Controller;
use app\request\AuthorCreateRequest;
use app\request\AuthorIndexRequest;
use app\request\AuthorUpdateRequest;
use app\useCase\AuthorCreateUseCase;
use app\useCase\AuthorIndexUseCase;
use app\useCase\AuthorUpdateUseCase;
use yii\filters\auth\HttpHeaderAuth;

class AuthorController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpHeaderAuth::class,
            'except' => ['index', 'view'],
        ];

        return $behaviors;
    }

    public function actionIndex(): array
    {
        $request = \Yii::$container->get(
            AuthorIndexRequest::class,
            ['attributes' => \Yii::$app->request->get()]
        );
        $request->validate();

        $useCase = \Yii::$container->get(AuthorIndexUseCase::class);
        $dataProvider = $useCase->execute($request);

        return $this->formatDataProvider($dataProvider, ['books']);
    }

    public function actionCreate(): array
    {
        $request = \Yii::$container->get(
            AuthorCreateRequest::class,
            ['attributes' => \Yii::$app->request->post()]
        );
        $request->validate();
        $useCase = \Yii::$container->get(AuthorCreateUseCase::class);
        $author = $useCase->execute($request);

        return [
            'data' => $author,
        ];
    }

    public function actionUpdate(int $id): array
    {
        $request = \Yii::$container->get(
            AuthorUpdateRequest::class,
            ['attributes' => \Yii::$app->request->post()]
        );
        $request->id = $id;
        $request->validate();
        $useCase = \Yii::$container->get(AuthorUpdateUseCase::class);
        $author = $useCase->execute($request);

        return [
            'data' => $author,
        ];
    }
}
