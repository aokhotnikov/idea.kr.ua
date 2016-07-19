<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\db\Query;


$this->title = "Предложи идею";
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
    <!-- Ideas sorting -->
    <div class="small-page-navi">
        <ul>
            <li class="active"><a href="/">По времени публикации</a></li>
            <li><a href="/?sort=2">Самые популярные</a></li>
            <li><a href="/?sort=3">Реализованные идеи</a></li>
        </ul>
    </div>
    <!-- /Ideas sorting -->

    <div id="news-list" class="list-view">
        <div class="items">

            <!-- Idea -->
            <div class="idea-block">
                <div class="left-block">
                    <a href="#" onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : ''?>" class="btn btn-idea-up"><i
                            class="fa fa-thumbs-o-up"></i></a>
                    <a href="#" onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : ''?>" class="btn btn-idea-down"><i
                            class="fa fa-thumbs-o-down"></i></a>

                    <p class="idea-status"><span class="itog">Всего:</span><span
                            class="votes-count"><?= $post["like"] + $post["dislike"] ?></span></p>
                </div>
                <div class="right-block">

                    <p class="idea-name"><?= $post["title"] ?></p>

                    <p class="small-p">Опубликовано: <?= $post["date_publ"] ?></p>

                    <p class="small-p">Автор идеи: <span><?= $post["firstname"] ?></span></p>

                    <p><?= $post["text"] ?></p>
                    <ul class="ideas-tags list-inline">
                        <?php
                        $masTags = explode(",", $post["tags"]);
                        foreach ($masTags as $tag) {
                            ?>
                            <li>
                                <?= Html::a($tag , ['main/index', 'tag' => $tag]) ?>
                            </li>
                            <?php
                        }
                        $one = 1;
                        $com = (new Query())
                            ->select('c.post_id, count(*) as num')
                            ->from('comments c')
                            ->where('c.post_id = '.$post[id].' and c.is_moderate = '.$one.'')->all();
                        ?>
                    </ul>
                    <div class="news-date"><i class="fa fa-comments-o"></i> <a href=/comment/<?= $post["id"] ?>> Комментариев: </a> <?= $com[0]["num"]; ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- /Idea -->

        </div>

    </div>
</div>
