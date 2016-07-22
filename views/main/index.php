<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;

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

        <?php
        $haveEmail = !Yii::$app->user->isGuest ? preg_match("/[0-9]*@idea.net/", Yii::$app->user->identity->email) : "";
        foreach ($posts as $post) { ?>

            <!-- Idea -->
            <div class="idea-block">
                <div class="left-block">
                    <a onclick="<?= Yii::$app->user->isGuest
                        ?   "$('#modalFormAuth').modal('show');"
                        :   ( $haveEmail  ?  "$('#modalFormEmailEnter').modal('show');"  :  "addVote(1,".$post['id'].")") ?>"
                       class="btn btn-idea-up vote-up-<?= $post["id"] ?>">
                        <i class="fa fa-thumbs-o-up"></i></a>
                    <a onclick="<?= Yii::$app->user->isGuest
                        ?   "$('#modalFormAuth').modal('show');"
                        :   ( $haveEmail  ?  "$('#modalFormEmailEnter').modal('show');"  :  "addVote(0,".$post['id'].")") ?>"
                       class="btn btn-idea-down vote-down-<?= $post["id"] ?>">
                        <i class="fa fa-thumbs-o-down"></i></a>

                    <p class="idea-status"><span class="itog">Всего:</span><span
                            class="votes-count-<?= $post["id"] ?>"><?= $post["like"] + $post["dislike"] ?></span></p>
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
                    <div class="news-date"><i class="fa fa-comments-o"></i> Комментариев: <?= $post["comments"] ?>
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

