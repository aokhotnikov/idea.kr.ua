<?php

use app\models\EmailForm;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;

$model = new EmailForm();

Modal::begin([
    'header' => '<h3 class="text-center"><span class="glyphicon glyphicon-envelope"></span> К вашему аккаунту не привязан E-mail</h3>',
    'size' => 'modal-size',
    'id' => 'modalFormEmailEnter'
]);

?>
    <div class="user-form-lg">

        <?php $form = ActiveForm::begin([
            'action' => ['main/add-email'],
            'enableClientValidation' => false, //клиентскую валидацию можно отключать (для дебага серверной или для AJAX валидации)
            'enableAjaxValidation' => true,
        ]); ?>

        <div class="form-group">
            <?= $form->field($model, 'email')?>
        </div>

        <div class="form-group submit text-center">
            <input class="btn btn-default" type="submit" name="email" value="Сохранить"/>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
Modal::end();
?>