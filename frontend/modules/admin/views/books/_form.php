<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Books */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="books-form">

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
                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'public_date')->widget(\yii\jui\DatePicker::class, [
                    'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd',
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]) ?>
                <?= $form->field($model, 'genre')->dropDownList($model->geSelectGenre(), [
                    'class' => 'form-control prompt',
                    'prompt' => 'Выберите жанр',
                ]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'pages', ['options' => ['class' => 'col-sm-4']])->textInput(['type' => 'number']) ?>
                <?= $form->field($model, 'publishing', ['options' => ['class' => 'col-sm-4']])->textInput(['maxlength' => true]) ?>
            </div>
            <div class="row">
                <?= $form->field($model, 'count', ['options' => ['class' => 'col-sm-4']])->textInput(['type' => 'number']) ?>
                <?= $form->field($model, 'department_id', ['options' => ['class' => 'col-sm-4']])->dropDownList(\common\models\Departments::getToSelect(), [
                    'class' => 'form-control prompt',
                    'prompt' => 'Выберите отдел',
                ]) ?>
                <?= $form->field($model, 'rack_id')->dropDownList(
                    \common\models\Racks::getToSelectByDepartment($model->department_id), [
                        'disabled'  => !isset($model->department_id) ? true : false
                    ]);
                ?>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div><?php

$this->registerJs('
    $("#books-department_id").on("change", function(){
        var element = $(this),
        departmentId = element.val(),
        rack = $("#books-rack_id");
        $.ajax({
           url: "get-select-racks",
           type: "POST",
           data: {departmentId: departmentId}
        }).done(function(response){
            if (response) {
                $(rack).find("option").not(":eq(0)").remove();
                $(rack).prop({disabled: false, selectedIndex: 0});
                $.each(response, function(id, label) {
                    $(rack).append("<option value=\"" + id + "\">" + label + "</option>");
                });
                $(rack).material_select();
            } else {
                $(rack).find("option").not(":eq(0)").remove();
                $(rack).prop({disabled: true, selectedIndex: 0});
            }
        });
    });
');
        