<?php

use yii\db\Query;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Comments;

$model = new Comments();

Modal::begin([
    'header' => '<h3 class="text-center">Введите ваш коментарий!</h3>',
    'toggleButton' => [
        'tag' => 'a',
        'class' => 'btn btn-default',
        'id' => 'btn-com',
    ],
    'size' => 'modal-size'
]);


?>
<div class="user-form-lg">
    <?php $form = ActiveForm::begin([
        'action' => ['post/submit'],
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'comment')->label('Ваш коментарий') ?>
        <?= $form->field($model, 'post_id')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>

    </div>

    <div class="form-group submit text-center">
        <input class="btn btn-default" type="submit" value="Отправить"/>

        <br><br>

    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::end();
?>
