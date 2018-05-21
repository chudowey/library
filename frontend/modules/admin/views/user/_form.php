<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'options' => [
                'class' => 'input-field col-sm-4'
            ]
        ]
    ]); ?>

    <div class="elements">
        <div class="row-group">
            <div class="row">
                <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->User, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'user_password')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model->User, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->User, 'surname')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->User, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model->User, 'birthday')->widget(\yii\jui\DatePicker::class, [
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]) ?>
                <?= $form->field($model->User, 'phone')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model->User, 'pasport')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model->User, 'status')->dropDownList($model->User->geSelectStatus()) ?>
                <?= $form->field($model->User, 'role')->dropDownList($model->User->getListRole()) ?>
            </div>
            <div class="row">
                <?= $form->field($model->User, 'address', ['options' => ['class' => 'col-sm-8']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
