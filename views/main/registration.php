<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Регистрация';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Идея, новая, предложить']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Генератор идей']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => 'src/favicon.ico',
]);
$this->params['activeTags'] = 'all';
?>
<div class="ideas-center">
    <div class="user-form-lg">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('registrationSubmitted')): ?>

            <div class="alert alert-success text-center">
                Спасибо, <?= Yii::$app->user->identity->firstname ?>, что зарегистрировались :)
            </div>

        <?php else: ?>

            <?php $form = ActiveForm::begin([
                'enableClientValidation' => false, //клиентскую валидацию отключил (для дебага серверной или для AJAX валидации)
                'enableAjaxValidation' => true,
            ]); ?>

            <?= $form->field($model, 'fname')->label('Имя:') ?>
            <?= $form->field($model, 'lname')->label('Фамилия:') ?>
            <?= $form->field($model, 'email')->label('E-mail:') ?>
            <?= $form->field($model, 'age')->label('Возраст') ?>
            <?= $form->field($model, 'pass')->label('Пароль')->passwordInput() ?>
            <?= $form->field($model, 'repass')->passwordInput() ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        <?php endif; ?>
    </div>
</div>