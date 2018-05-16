<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Racks */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Полки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="racks-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить эту полку?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'value' => $model->department->name,
                'label' => 'Отдел',
            ],
        ],
    ]) ?>

</div>
