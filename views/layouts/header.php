<?php
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

NavBar::begin([
    'brandLabel' => '<img src="/src/lamp.png" alt="idea" width="60px" height="60px" class="small-navi">IDEA.KR.UA',
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
            ?   ['label' => 'ВХОД', 'linkOptions' => ['onclick' => "$('#modalFormAuth').modal('show');"] ]
            :   (Yii::$app->user->identity->banned
                        ?   ""
                        :   (preg_match("/[0-9]*@idea.net/", Yii::$app->user->identity->email)
                                ?   [
                                        'label' => 'Добавить',
                                        'linkOptions' => [
                                            'onclick' => "$('#modalFormEmailEnter').modal('show');"
                                        ]
                                    ]
                                :   [
                                        'label' => 'Добавить',
                                        'url' => ['/main/add-idea']
                                    ]
                            )
                ),
        !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin
            ?   [
                    'label' => 'Админ',
                    'url' => ['/admin/index'],
                    'active' => in_array(Yii::$app->controller->id, ['users', 'admin', 'posts']) // in_array - присутствует ли в массиве значение controllerа
                ]
            : "",
        !Yii::$app->user->isGuest
            ?   ['label' => 'Выйти (' . Yii::$app->user->identity->firstname . ')', 'url' => ['/logout']]
            :   ""
    ],
]);
NavBar::end();


?>



