<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Редактирование: ' . $model->firstname . " " . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="users-update ideas-center">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="users-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pass')->passwordInput(['maxlength' => true, 'disabled' => true]) ?>

        <?= $form->field($model, 'salt')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'isAdmin')->dropDownList(['0' => 'Нет','1' => 'Да']) ?>

        <?= $form->field($model, 'banned')->dropDownList(['0' => 'Нет','1' => 'Да']) ?>

        <?= $form->field($model, 'age')->textInput() ?>

        <?= $form->field($model, 'token')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true, 'disabled' => true]) ?>

        <?= $form->field($model, 'fb_id')->textInput(['disabled' => true]) ?>

        <?= $form->field($model, 'vk_id')->textInput(['disabled' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
