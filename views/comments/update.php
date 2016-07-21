<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Редактирование идеи';
$this->params['breadcrumbs'][] = ['label' => 'Commets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Moderating", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';


?>
<div class="comments-update ideas-center">

    <h2><?= Html::encode("Редактирование коментария") ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>
    Время публикации :
    <?= $model->time ?> &nbsp;&nbsp;
    ID Авторa :
    <?= $model->author_id ?>    <p>
<!--    --><?//= $form->field($model, 'text')->textArea(['rows' => 15]) ?>

<!--    --><?//= $form->field($model, 'is_moderate')->dropDownList(['0' => 'Нет','1' => 'Да']) ?>

<!--    --><?//= $form->field($model, 'is_moderate')->dropDownList([
//        'new' => 'Новый',
//        'isApproved' => 'Утверждён',
//        'isRejected' => 'Отклонен'
//    ]) ?>
    <?php
    //        echo "<br><pre>";print_r($model->tagsPosts);echo "</pre><br>";
    //        foreach ($model->tagsPosts as $tagpost){
    //            echo $tagpost->tag->name."<br>";
    //        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить коментарий?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
