<?php

namespace app\controllers;

use app\models\Book;
use app\request\BookCreateRequest;
use app\request\BookIndexRequest;
use app\useCase\BookCreateUseCase;
use app\useCase\BookIndexUseCase;
use app\useCase\BookViewUseCase;
use app\useCase\UseCaseInterface;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class BookController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete'],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'view'],
                    'roles' => ['?', '@'],
                ],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all Book models.
     */
    public function actionIndex(): string
    {
        $request = \Yii::$container->get(BookIndexRequest::class, ['attributes' => \Yii::$app->request->get()]);
        $useCase = \Yii::$container->get(BookIndexUseCase::class);

        return $this->render('index', [
            'dataProvider' => $useCase->execute($request),
        ]);
    }

    /**
     * Displays a single Book model.
     */
    public function actionView(int $id): string
    {
        $request = \Yii::$container->get(BookIndexRequest::class, ['attributes' => ['id' => $id]]);
        $useCase = \Yii::$container->get(BookViewUseCase::class);
        $model = $useCase->execute($request);
        return $this->render('view', [
            'model' => $model
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate(): string|\yii\web\Response
    {
        if ($this->request->isPost) {
            $request = \Yii::$container->get(
                BookCreateRequest::class,
                ['attributes' => \Yii::$app->request->post('Book')]
            );
            $useCase = \Yii::$container->get(BookCreateUseCase::class);
            $book = $useCase->execute($request);
            return $this->redirect(['view', 'id' => $book->id]);
        }

        return $this->render('create', [
            'book' => new Book(),
        ]);
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
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
