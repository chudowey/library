<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderCard */

$this->title = $model->book->name;
$this->params['breadcrumbs'][] = ['label' => 'Выдача книг', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$classTake = $model->status ? 'hidden' : '';
?>
<div class="reader-card-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Продлить на неделю', ['prolong', 'id' => $model->id], ['class' => "btn btn-primary {$classTake}"]) ?>
        <?= Html::a('Принять книгу', ['take', 'id' => $model->id], ['class' => "btn btn-primary {$classTake}" ]) ?>
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
            [
                'label' => 'Код книги',
                'attribute' => 'book.code'
            ],
            [
                'label' => 'Название книги',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->book->name, ['book/view', 'id' => $model->book_id]);
                }
            ],
            [
                'label' => 'Автор книги',
                'attribute' => 'book.author'
            ],
            [
                'label' => 'Читатель',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->reader->name . ' ' . $model->reader->surname . ' ' . 'id:' . ' ' . $model->reader_id, ['user/view', 'id' => $model->reader_id]);
                }
            ],
            [
                'label' => 'Сотрудник, выдававший книгу',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->employee->name . ' ' . $model->employee->surname, ['user/view', 'id' => $model->employee_id]);
                }
            ],
            'date_operation',
            'date_return',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusName();
                }
            ],
        ],
    ]) ?>

</div>
