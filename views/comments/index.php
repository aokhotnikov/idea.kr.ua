<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комментарии';
?>

<!-- Comments sorting -->
<div class="small-page-navi">
    <ul>
        <li class="<?= !$activeLabelCommentSort ? 'active' : ''; ?>">
            <a href="/comments/index">Новые комментарии</a>
        </li>
        <li class="<?= $activeLabelCommentSort ? 'active' : ''; ?>">
            <a href="/comments/index?sort=1">Прошли модерацию</a>
        </li>
    </ul>
</div>
<!-- /Comments sorting -->

<?php Pjax::begin();
echo GridView::widget([
    'dataProvider' => $model,
    'showHeader' => false,
    'pager' => [
        'options' => [
            'class' => 'pager',
        ]
    ],
    'summaryOptions' => ['class' => 'summary text-center'],
    'columns' => [
        ['attribute' => 'id', 'label' => 'N'],
        ['attribute' => 'text', 'label' => 'Текст'],
        ['attribute' => 'date_created', 'label' => 'Дата создания'],
        [
            'class' => 'yii\grid\ActionColumn',
            'controller' => 'comments',
            'template' => $activeLabelCommentSort ? '{update}<br/>{delete}' : '{approve}<br/>{update}<br/>{delete}',
            'buttons' => [
                'approve' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-ok"></span>', $url, [
                        'title' => 'Утвердить',
                    ]);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-scissors"></span>', $url, [
                        'title' => 'Редактировать',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'title' => 'Удалить',
                        'data' => [
                            'confirm' => "Вы действительно хотите удалить комментарий?",
                            'method' => 'post',
                        ],
                    ]);
                },
            ]
        ],
    ]
]);
Pjax::end();
?>
