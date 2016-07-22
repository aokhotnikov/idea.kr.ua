<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showHeader' => true,
    'pager' => [
        'options' => [
            'class' => 'pager',
        ]
    ],
    'summaryOptions' => ['class' => 'summary text-center'],
    'columns' => [
        ['attribute' => 'id', 'label' => '#'],
        ['attribute' => 'firstname', 'label' => 'Имя'],
        ['attribute' => 'lastname', 'label' => 'Фамилия'],
        'email:email',
        ['attribute' => 'isAdmin', 'label' => 'Админ'],
        ['attribute' => 'banned', 'label' => 'Забанен'],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'users',
            'template' => '{update}<br>{view}<br>{change-ban}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, [
                        'title' => 'Редактировать',
                    ]);
                },
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                        'title' => 'Просмотр',
                    ]);
                },
                'change-ban' => function ($url, $model) {
                    return $model->banned
                        ?   Html::a('<span class="glyphicon glyphicon-plus-sign"></span>', $url.'&ban=0', [
                            'title' => 'Разбанить'
                        ])
                        :   Html::a('<span class="glyphicon glyphicon-minus-sign"></span>', $url.'&ban=1', [
                            'title' => 'Забанить',
                            'data-confirm' => 'Вы действительно хотите забанить пользователя '.$model->firstname.'?',
                        ]);
                }
            ]
        ],
    ]
]);

?>

