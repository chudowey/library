<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Racks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="racks-form">

    <?php $form = ActiveForm::begin(); ?>
 	<div class="row">
 		<div class="col-sm-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
		<div class="col-sm-6"><?= $form->field($model, 'department_id')->dropDownList(\common\models\Departments::getToSelect(), [
			'class' => 'form-control prompt',
            'prompt' => 'Выберите отдел',
		]) ?></div>
	</div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
