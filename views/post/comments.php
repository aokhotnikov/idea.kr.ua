<?php
/* @var $this yii\web\View */
use yii\helpers\Html;

$this->params['activeTags'] = 'all';

?>
<div class="ideas-center">
    <div id="news-list" class="list-view">
        <div class="items">

            <!-- Idea -->
            <div class="idea-block">
                <div class="left-block">
                    <a href="#" onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : ""?>" class="btn btn-idea-up">
                        <i class="fa fa-thumbs-o-up"></i></a>
                    <a href="#" onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : ''?>" class="btn btn-idea-down">
                        <i class="fa fa-thumbs-o-down"></i></a>

                    <p class="idea-status"><span class="itog">Всего:</span>
                        <span class="votes-count"><?= $post[0]["like"] + $post[0]["dislike"] ?></span></p>
                </div>
                <div class="right-block">

                    <p class="idea-name"><?= $post[0]["title"] ?></p>

                    <p class="small-p">Опубликовано: <?= $post[0]["date_publ"] ?></p>

                    <p class="small-p">Автор идеи: <span><?= $post[0]["firstname"] ?></span></p>

                    <p><?= $post[0]["text"] ?></p>

                    </div>
                 <!-- add one more button before first comment if number of comments more than ten    -->
                <?php if(count($post)>= 10){ ?>
                    <form class="form-inline" role="form">
                    <div class="form-group">
                        <a  onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : "$('#btn-com').click()"?>" class="btn btn-default">Добавить коментарий</a>
                    </div>
                </form>
               <?php   }  ?>

                <hr>


                <?php

                foreach ($post as $comment) {
                    if($comment["comment"] != ""){ ?>
                   <div class="actionBox">
                        <ul class="commentList">
                            <p>Автор: <?= $comment["firstname"] ?></p>
                            <li>
                                <div class="commentText">
                                    <p class=""><?= $comment["comment"] ?></p> <span class="date sub-text">Опубликовано: <?= $comment["time"] ?></span>
                                    <hr>
                                </div>
                            </li>
                        </ul>
                    </div>

                <?php }   } ?>
                <form class="form-inline" role="form">

                    <div class="form-group">
                        <a  onclick="<?= Yii::$app->user->isGuest ? "$('#btn-auth').click()" : "$('#btn-com').click()"?>" class="btn btn-default">Добавить коментарий</a>
                    </div>
                </form>
                </div>
             <!-- /Idea -->

        </div>

    </div>
</div>
