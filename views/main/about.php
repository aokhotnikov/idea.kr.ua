<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'О нас';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'О портале, идея, новая, предложить']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Сайт для генерации идей']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => 'src/favicon.ico',
]);
$this->params['activeTags'] = 'all';
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    бла-бла-бла
</div>
