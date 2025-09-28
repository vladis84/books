<?php

declare(strict_types=1);

namespace app\controllers;

use app\components\Controller;
use app\request\AuthorCreateRequest;
use app\request\AuthorIndexRequest;
use app\useCase\AuthorCreateUseCase;
use app\useCase\AuthorIndexUseCase;
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
        $pagination = $dataProvider->getPagination();

        return [
            'data' => $dataProvider->getModels(),
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'page' => $pagination->getPage() + 1,
                'pageSize' => $pagination->getPageSize(),
                'pageCount' => $pagination->getPageCount(),
            ],
        ];
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
}
