<?php
/* @var $this yii\web\View */
use yii\captcha\Captcha;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Добавление Идеи';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Добавить, идея, новая, предложить']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Форма добавления идей']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => 'src/favicon.ico',
]);
$this->params['activeTags'] = 'all';
//echo "<pre>";print_r($tags);echo "</pre>";
?>
<div class="ideas-center">
    <div class="user-form-lg">

        <h1><?= Html::encode($this->title) ?></h1>

        <?php if (Yii::$app->session->hasFlash('ideaAddSubmitted')): ?>

            <div class="alert alert-success text-center">
                Спасибо, <?= Yii::$app->user->identity->firstname ?>, что добавили идею :)
            </div>

        <?php else: ?>

            <?php $form = ActiveForm::begin([
                //'enableClientValidation' => false, //клиентскую валидацию отключил (для дебага серверной или для AJAX валидации)
                //'enableAjaxValidation' => true,    //если включить, не работает каптча
            ]); ?>

            <?= $form->field($model, 'title')->label('Тема:') ?>

            <?= $form->field($model, 'tags[]')->label('Категории:')->dropDownList($tags, ['multiple' => 'multiple', 'id' => 'tags', 'class' => 'form-control']) ?>

            <?= $form->field($model, 'text')->textArea(['rows' => 10])->label('Описание:') ?>

            <?= $form->field($model, 'verifyCode')->label('Проверочный код:')->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-2 text-right">{image}</div><div class="col-lg-3">{input}</div></div>',
                'captchaAction' => 'main/captcha',
            ]) ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        <?php endif; ?>

    </div>
</div>