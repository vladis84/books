<?php

namespace app\controllers;

use app\components\Controller;
use app\models\Book;
use app\request\BookCreateRequest;
use app\request\BookIndexRequest;
use app\request\BookUpdateRequest;
use app\request\BookViewRequest;
use app\useCase\BookCreateUseCase;
use app\useCase\BookIndexUseCase;
use app\useCase\BookUpdateUseCase;
use app\useCase\BookViewUseCase;
use yii\filters\auth\HttpHeaderAuth;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

    /**
     * Displays a single Book model.
     */
    public function actionView(int $id): array
    {
        $request = \Yii::$container->get(BookIndexRequest::class, ['attributes' => ['id' => $id]]);
        $useCase = \Yii::$container->get(BookViewUseCase::class);
        $book = $useCase->execute($request);

        return [
            'data' => $book,
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
            'data' => $book,
        ];
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): string|Response
    {
        $request = \Yii::$container->get(
            BookUpdateRequest::class,
            [
                'attributes' => \Yii::$app->request->post('BookUpdateRequest') ?? [],
            ]
        );
        $request->id = $id;

        if ($this->request->isPost && $request->validate()) {
            $updateUseCase = \Yii::$container->get(BookUpdateUseCase::class);
            $bookId = $updateUseCase->execute($request);

            return $this->redirect(['view', 'id' => $bookId]);
        } else {
            $viewRequest = \Yii::$container->get(BookViewRequest::class, ['attributes' => ['id' => $id]]);
            $useCase = \Yii::$container->get(BookViewUseCase::class);
            $book = $useCase->execute($viewRequest);
            $request->setAttributes($book->getAttributes());
        }

        return $this->render('update', ['request' => $request]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
