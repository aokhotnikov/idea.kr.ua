<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
use yii\db\Query;

$this->title = "Предложи идею";
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Идея, новая, предложить']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Генератор идей']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => 'src/favicon.ico',
]);

$posts = $model->getModels();
$this->params['activeTags'] = $activeTags;
$activeTags = str_replace (' ', '+', $activeTags);
?>
<!-- ---------------------------Ideas---------------------------- -->
<div class="ideas-center">

    <!-- Ideas sorting -->
    <div class="small-page-navi">
        <ul>
            <?php if ($activeTags != 'all') :?>

                <li class="<?= $activeLabelIdeaSort == 1 ? 'active' : '';?>" >
                    <a href="/?tag=<?= $activeTags?>">По времени публикации</a>
                </li>
                <li class="<?= $activeLabelIdeaSort == 2 ? 'active' : '';?>" >
                    <a href="/?tag=<?= $activeTags?>&sort=2">Самые популярные</a>
                </li>
                <li class="<?= $activeLabelIdeaSort == 3 ? 'active' : '';?>" >
                    <a href="/?tag=<?= $activeTags?>&sort=3">Реализованные идеи</a>
                </li>

            <?php else: ?>

                <li class="<?= $activeLabelIdeaSort == 1 ? 'active' : '';?>" >
                    <a href="/">По времени публикации</a>
                </li>
                <li class="<?= $activeLabelIdeaSort == 2 ? 'active' : '';?>" >
                    <a href="/?sort=2">Самые популярные</a>
                </li>
                <li class="<?= $activeLabelIdeaSort == 3 ? 'active' : '';?>" >
                    <a href="/?sort=3">Реализованные идеи</a>
                </li>

            <?php endif; ?>
        </ul>
    </div>
    <!-- /Ideas sorting -->


    <div id="news-list" class="list-view">
        <div class="items">

            <?php foreach ($posts as $post) { ?>

                <!-- Idea -->
                <div class="idea-block">
                    <div class="left-block">
                        <a href="#" onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : ''?>" class="btn btn-idea-up">
                            <i class="fa fa-thumbs-o-up"></i></a>
                        <a href="#" onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : ''?>" class="btn btn-idea-down">
                            <i class="fa fa-thumbs-o-down"></i></a>

                        <p class="idea-status"><span class="itog">Всего:</span><span
                                class="votes-count"><?= $post["like"] + $post["dislike"] ?></span></p>
                    </div>
                    <div class="right-block">
                        <a href="/post/<?= $post["id"] ?>" class="idea-name"><?= $post["title"] ?></a>

                        <p class="small-p">Опубликовано: <?= $post["date_publ"] ?></p>

                        <p class="small-p">Автор идеи: <span><?= $post["firstname"] ?></span></p>

                        <p><?= $post["short_text"] ?>...<a
                                href="/post/<?= $post["id"] ?>">Подробнее</a></p>
                        <ul class="ideas-tags list-inline">
                            <?php
                            $masTags = explode(",", $post["tags"]);
                            foreach ($masTags as $tag) {
                            ?>
                                <li>
                                    <a href="?tag=<?= str_replace (' ','+',$tag) ?>"><?= $tag ?></a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                        <?php
                        $one = 1;
                        $com = (new Query())
                            ->select('c.post_id, count(*) as num')
                            ->from('comments c')
                            ->where('c.post_id = '.$post[id].' and c.is_moderate = '.$one.'')->all();
                        ?>
                        <div class="news-date"><i class="fa fa-comments-o"></i>
                            <?php if($com[0]["num"]==0){
                                $url_comments = "/comment/";
                            }else{
                                $url_comments = "/comment/";
                            }
                            ?>
                            <a href=<?=$url_comments?><?= $post["id"] ?>> Комментариев: </a>
                            <?=
                            $com[0]["num"];
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- /Idea -->

            <?php } ?>

            <div class="pagination-block">

                <?php
                echo LinkPager::widget([
                    'pagination' => $model->pagination,
                    'options' => [
                        'class' => 'pager',
                    ]
                ]);
                ?>

            </div>
        </div>

    </div>

    <!-- /Ideas -->
</div>