<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;


NavBar::begin([
    'brandLabel' => '<img src="/src/lamp.png" alt="idea" width="80px" height="35px" class="small-navi">IDEA.KR.UA',
    'brandUrl' => Yii::$app->homeUrl,
    'brandOptions' => [
        'class' => 'navbar-brand'
    ],
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
echo Nav::widget([
    'options' => ['class' => 'nav nav-pills navbar-right mymenu'],
    'items' => [
        ['label' => 'Главная', 'url' => ['/main/index']],
        ['label' => 'О нас', 'url' => ['/main/about']],
        Yii::$app->user->isGuest
            ?   ['label' => 'ВХОД', 'linkOptions' => ['onclick' => '$(\'#btn-auth\').click();'] ]
            :   ['label' => 'Добавить', 'url' => ['/main/add-idea']],
        !Yii::$app->user->isGuest
            ?   ['label' => 'Выйти (' . Yii::$app->user->identity->firstname . ')', 'url' => ['/logout']]
            :   ""
    ],
]);
NavBar::end();


?>



