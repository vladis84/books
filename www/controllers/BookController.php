<?php

namespace app\controllers;

use app\components\Controller;
use app\request\BookCreateRequest;
use app\request\BookIndexRequest;
use app\request\BookUpdateRequest;
use app\useCase\BookCreateUseCase;
use app\useCase\BookIndexUseCase;
use app\useCase\BookUpdateUseCase;
use app\useCase\BookViewUseCase;
use yii\filters\auth\HttpHeaderAuth;

class BookController extends Controller
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

    /**
     * Lists all Book models.
     */
    public function actionIndex(): array
    {
        $request = \Yii::$container->get(BookIndexRequest::class, ['attributes' => \Yii::$app->request->get()]);
        $useCase = \Yii::$container->get(BookIndexUseCase::class);
        $dataProvider = $useCase->execute($request);

        return $this->formatDataProvider($dataProvider, ['authors']);
    }

    /**
     * Displays a single Book model.
     */
    public function actionView(int $id): array
    {
        $request = \Yii::$container->get(BookIndexRequest::class, ['attributes' => ['id' => $id]]);
        $useCase = \Yii::$container->get(BookViewUseCase::class);
        $book = $useCase->execute($request);

        return [
            'data' => $book->toArray(expand: ['authors']),
        ];
    }

    public function actionCreate(): array
    {
        $request = \Yii::$container->get(
            BookCreateRequest::class,
            ['attributes' => \Yii::$app->request->post()]
        );

        $request->validate();
        $useCase = \Yii::$container->get(BookCreateUseCase::class);
        $book = $useCase->execute($request);

        return [
            'data' => $book->toArray(expand: ['authors']),
        ];
    }

    public function actionUpdate(int $id): array
    {
        $request = \Yii::$container->get(
            BookUpdateRequest::class,
            [
                'attributes' => \Yii::$app->request->post(),
            ]
        );
        $request->id = $id;
        $request->validate();
        $useCase = \Yii::$container->get(BookUpdateUseCase::class);
        $book = $useCase->execute($request);

        return [
            'data' => $book->toArray(expand: ['authors']),
        ];
    }
}
