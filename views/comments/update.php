<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Comments */

$this->title = 'Редактирование комментария: ';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Редатирование';
?>

<h2><?= Html::encode($this->title) ?></h2>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'date_created')->textInput() ?>

<?= $form->field($model, 'text')->textarea(['rows' => 5, 'autofocus' => true]) ?>

<?= $form->field($model, 'moderated')->dropDownList(
    ['1' => 'Да', 0 => 'Нет'],
    [
        'options' => [
            '1' => [
                'selected' => true
            ],
            '0' => [
                'selected' => false
            ]
        ]
    ]) ?>

<div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы действительно хотите удалить комментарий?',
            'method' => 'post',
        ],
    ]) ?>
</div>

<?php ActiveForm::end(); ?>

