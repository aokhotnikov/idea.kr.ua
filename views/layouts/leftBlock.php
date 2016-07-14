<?php

use app\models\Posts;
use yii\db\Query;
use yii\helpers\Html;

$tags = (new Query())
            ->select('tp.tag_id, t.name, count(*) as num')
            ->from('tags_posts tp, tags t, posts p')
            ->where('tp.tag_id=t.id and p.id = tp.post_id')
            ->andWhere('p.status = "isApproved"')
            ->groupBy('tp.tag_id')
            ->all();
?>
<!-- ---------------------------Left block----------------------- -->
<div class="ideas-left">
    <h5>Идеи по категориям</h5>

    <ul class="ideas-list">
        <li class="<?= $activeTags === 'all' ? 'active' : '' ?>" >
            <a href="/">Все идеи <sup><?= Posts::find()->where('status = "isApproved"')->count() ?></sup></a>
        </li>
        <?php foreach ($tags as $tag): ?>
            <li class="<?= $activeTags === $tag['name'] ? 'active' : '' ?>" >
                <?= Html::a($tag['name'] .Html::tag('sup', $tag['num']) , ['main/index', 'tag' => $tag['name']]) ?>
            </li>
        <?php endforeach ?>
    </ul>
</div>
<!-- /Left block -->
<?php
//echo '<pre>';print_r($activeTags);echo '</pre>';die; // for debag