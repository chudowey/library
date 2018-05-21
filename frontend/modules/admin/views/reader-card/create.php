<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ReaderCard */

$this->title = 'Создание записи';
$this->params['breadcrumbs'][] = ['label' => 'Запись', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reader-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
