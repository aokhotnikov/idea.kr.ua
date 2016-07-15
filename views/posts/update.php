<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = 'Редактирование идеи';
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$options = [];
$masTags = ArrayHelper::getColumn($tags, 'name');
foreach ($masTags as $tag){
    $options[$tag] = ['Selected' => 'true'];
}
?>
<div class="posts-update ideas-center">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_text')->textArea(['rows' => 3]) ?>

    <?= $form->field($model, 'date_publ')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'like')->textInput() ?>

    <?= $form->field($model, 'dislike')->textInput() ?>

    <?= $form->field($model, 'comments')->textInput() ?>

    <?= $form->field($model, 'text')->textArea(['rows' => 15]) ?>

    <?= $form->field($model, 'completed')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList([
        'new' => 'Новый',
        'isApproved' => 'Утверждён',
        'isRejected' => 'Отклонен'
    ]) ?>

    <?= $form->field($model, 'tagz[]')->label('Категории:')->dropDownList(
        ArrayHelper::map($tags, 'name', 'name'),
        [
            'multiple' => 'multiple',
            'id' => 'tags',
            'class' => 'form-control',
            'options' => $options
        ]
    ) ?>

    <?php
    //        echo "<br><pre>";print_r($model->tagsPosts);echo "</pre><br>";
    //        foreach ($model->tagsPosts as $tagpost){
    //            echo $tagpost->tag->name."<br>";
    //        }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Редактировать', ['class' => 'btn btn-primary']) ?>
        <?= $model->status === 'new' ? Html::a('Утвердить', ['/posts/change-status?status=1&id=' . $model['id']], ['class' => 'btn btn-success']) : '' ?>
        <?= $model->status === 'new' ? Html::a('Отклонить', ['/posts/change-status?status=0&id=' . $model['id']], ['class' => 'btn btn-warning']) : '' ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить идею?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
