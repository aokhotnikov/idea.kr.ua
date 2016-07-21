<?php
/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\helpers\Html;


$this->title = "Админка";
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Админ']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Админ']);
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
                <a href="/admin/index">Новые идеи</a>
            </li>
            <li class="<?= $activeLabelIdeaSort == 2 ? 'active' : '';?>" >
                <a href="/admin/index?sort=2">Утверждённые идеи</a>
            </li>
            <li class="<?= $activeLabelIdeaSort == 3 ? 'active' : '';?>" >
                <a href="/admin/index?sort=3">Отвергнутые идеи</a>
            </li>
        </ul>
    </div>
    <!-- /Ideas sorting -->

    <?php
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
            ['attribute' => 'title', 'label' => 'Тема'],
            ['attribute' => 'date_publ', 'label' => 'Дата создания'],
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'posts',
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