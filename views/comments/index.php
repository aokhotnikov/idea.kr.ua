<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
$this->title = "Предложи идею";
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Идея, новая, предложить']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Генератор идей']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => 'src/favicon.ico',
]);
$posts = $model->getModels();
?>
<!-- ---------------------------Ideas---------------------------- -->
<div class="ideas-center">

    <!-- Ideas sorting -->
    <div class="small-page-navi">
        <ul>
            <li class="<?= $activeLabelIdeaSort == 1 ? 'active' : '';?>" >
                <a href="/comments/index">Новые комментарии</a>
            </li>
            <li class="<?= $activeLabelIdeaSort == 2 ? 'active' : '';?>" >
                <a href="/comments/index?sort=2">Проверенные</a>
            </li>
        </ul>
    </div>
    <!-- /Ideas sorting -->

    <?php
    echo GridView::widget([
        'dataProvider' => $model,
        'showHeader' => true,
        'pager' => [
            'options' => [
                'class' => 'pager',
            ]
        ],
        'summaryOptions' => ['class' => 'summary text-center'],
        'columns' => [
            ['attribute' => 'id', 'label' => 'N'],
            ['attribute' => 'comment', 'label' => 'Коментарий'],
            ['attribute' => 'time', 'label' => 'Дата создания'],

            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'comments',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Просмотреть', $url);
                    }
                ]
            ],
        ]
    ]);
    ?>

    <!-- /Ideas -->
</div>