<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\admin\models\ReaderCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Карточка читателя';
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                'attribute' => 'book_id',
                'value' => function ($model) {
                    return $model->book->code;
                },
            ],
            [
                'attribute' => 'book.name',
                'content' => function ($data) {
                    return count($model->reader->username);
                }
                /*'value' => function ($model) {
                    return $model->reader->username;
                },*/
            ],
            'book.name',
            'date_operation',
            'date_return',
            //'employee_id',
            //'created_at',
            //'updated_at',
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{delete}'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
