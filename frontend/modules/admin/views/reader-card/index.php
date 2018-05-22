<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\admin\models\ReaderCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Выдача книг';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reader-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать новую запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions'=>function($model){
            if($model->isOwesBook()){
                return ['class' => 'danger'];
            }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'book_id',
                'filter' => \common\models\Books::getToSelect(),
                'value' => function ($model) {
                    return $model->book->code;
                },
            ],
            'book.name',
            'book.author',
            [
                'attribute' => 'reader_id',
                'filter' => \common\models\User::getToSelect(),
                'content' => function ($model) {
                    return $model->reader->username;
                }
            ],
            [
                'attribute' => 'user.name',
                'label' => 'Имя читателя',
                'value' => function ($model) {
                    return $model->reader->name . ' ' . $model->reader->surname;
                }
            ],
            [
                'attribute' => 'date_operation',
                'format' => ['date', 'dd-MM-Y'],
            ],
            [
                'attribute' => 'date_return',
                'format' => ['date', 'dd-MM-Y'],
            ],
            [
                'attribute' => 'status',
                'filter' => ['Не возвращена', 'Возвращена'],
                'value' => function($model) {
                    return $model->getStatusName();
                }
            ],
            //'employee_id',
            //'created_at',
            //'updated_at',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
