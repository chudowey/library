<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Racks */

$this->title = 'Редактирование полки: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Полки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="racks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
