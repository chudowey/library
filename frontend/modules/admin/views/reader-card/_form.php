<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reader-card-form">
    <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'book')->widget(TypeaheadBasic::class, [
            'name' => 'state_17',
            'data' => \common\models\Books::getArrayCode(),
            'dataset' => ['limit' => 10],
            /*'options' => ['placeholder' => 'Filter as you type ...'],*/
            'pluginOptions' => ['highlight' => true, 'minLength' => 0]
        ])->hint('Введите код существующей книги') ?>
        <?= $form->field($model, 'reader')->widget(TypeaheadBasic::class, [
            'name' => 'state_17',
            'data' => \common\models\User::getArrayLogin(),
            'dataset' => ['limit' => 10],
            /*'options' => ['placeholder' => 'Filter as you type ...'],*/
            'pluginOptions' => ['highlight' => true, 'minLength' => 0]
        ])->hint('Введите логин читателя') ?>

        <?= $form->field($model->ReaderCard, 'date_operation')->widget(\yii\jui\DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'class' => 'form-control'
            ]
        ]) ?>
        <?= $form->field($model->ReaderCard, 'date_return')->widget(\yii\jui\DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
                'class' => 'form-control'
            ]
        ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
