<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderCard */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Выдача книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reader-card-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить запись?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'book_id',
            'reader_id',
            'employee_id',
            'date_operation',
            'date_return'
        ],
    ]) ?>

</div>
