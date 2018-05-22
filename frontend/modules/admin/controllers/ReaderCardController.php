<?php

namespace app\modules\admin\controllers;

use Yii;
use common\models\ReaderCard;
use frontend\modules\admin\models\ReaderCardForm;
use frontend\modules\admin\models\ReaderCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Books;
use common\models\User;

/**
 * ReaderCardController implements the CRUD actions for ReaderCard model.
 */
class ReaderCardController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ReaderCard models.
     * @return mixed
     */
    public function actionIndex($stat = 'all')
    {
        $searchModel = new ReaderCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $stat);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReaderCard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReaderCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReaderCardForm();
        $error = false;
        if ($post = Yii::$app->request->post()) {
            if (User::getCountBockToBiblio($post['ReaderCardForm']['reader'])) {
                if (Books::getCountBockToBiblio($post['ReaderCardForm']['book']) > 0) {
                    if ($model->save($post = Yii::$app->request->post())) {
                        return $this->redirect(['view', 'id' => $model->ReaderCard->id]);
                    }
                } else {
                    $error = "Все экземпляры выбранной книги (код:{$post['ReaderCardForm']['book']}) числятся у читателей";
                }
            } else {
                $error = "У читателя {$post['ReaderCardForm']['reader']} на руках больше 5 книг";
            }
        }

        return $this->render('create', [
            'model' => $model,
            'error' => $error,
        ]);
    }

    /**
     * Updates an existing ReaderCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ReaderCard model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReaderCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReaderCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReaderCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Продлить книгу
     */
    public function actionProlong($id)
    {
        if ($this->findModel($id)->prolongBook()) {
            return $this->redirect(['view', 'id' => $id]);
        }
    }

    /**
     * Принять книгу
     */
    public function actionTake($id)
    {
        if ($this->findModel($id)->takeBook()) {
            return $this->redirect(['view', 'id' => $id]);
        }
    }
}
