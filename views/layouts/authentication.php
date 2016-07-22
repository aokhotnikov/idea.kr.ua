<?php
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use app\models\AuthForm;

$model = new AuthForm();

Modal::begin([
    'header' => '<h3 class="text-center"><span class="glyphicon glyphicon-lock"></span> Авторизация</h3>',
    'size' => 'modal-size',
    'id' => 'modalFormAuth'
]);

?>
<div class="user-form-lg">
    <?php $form = ActiveForm::begin([
        'action' => ['auth/login'],
        'enableClientValidation' => false, //клиентскую валидацию можно отключать (для дебага серверной или для AJAX валидации)
        'enableAjaxValidation' => true,
        'fieldConfig' => [
            //'labelOptions' => ['class' => 'control-label'],
            //'inputOptions' => ['class' => 'form-control'],
        ],
    ]); ?>

    <div class="form-group">
        <?= $form->field($model, 'email')->label('E-mail') ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'password')->passwordInput() ?>
    </div>
    <div class="form-group">
        <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>

    <div class="form-group submit text-center">
        <input class="btn btn-default" type="submit" name="login" value="Войти"/>
        <a class="btn btn-primary" href="/registration">Регистрация</a>
        <br><br>
        <h4>Вход через соцсети</h4>
        <hr/>
        <a class="btn btn-social-login btn-facebook" title="facebook" href="/main/fb" style="margin-right: 10px">
            <i class="fa fa-facebook"></i>
        </a>
        <a class="btn btn-social-login btn-vk" title="vk.com" href="/main/auth?authclient=vkontakte">
            <i class="fa fa-vk"></i>
        </a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::end();
?>
