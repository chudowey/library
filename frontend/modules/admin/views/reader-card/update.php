<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderCard */

$this->title = 'Редактирование записи ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Редактирование', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="reader-card-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
