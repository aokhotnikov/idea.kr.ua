<?php
/* @var $this yii\web\View */
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Предложи идею";
$this->registerMetaTag(['name' => 'keywords', 'content' => 'Идея, новая, предложить']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Генератор идей']);
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => 'src/favicon.ico',
]);
$this->params['activeTags'] = 'all';
$haveEmail = !Yii::$app->user->isGuest ? preg_match("/[0-9]*@idea.net/", Yii::$app->user->identity->email) : "";
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

                    <p class="idea-name"><?= $post["title"] ?></p>

                    <p class="small-p">Опубликовано: <?= $post["date_publ"] ?></p>

                    <p class="small-p">Автор идеи: <span><?= $post["firstname"] ?></span></p>

                    <p><?= $post["text"] ?></p>
                    <ul class="ideas-tags list-inline">
                        <?php
                        $masTags = explode(",", $post["tags"]);
                        foreach ($masTags as $tag) : ?>
                            <li>
                                <?= Html::a($tag , ['main/index', 'tag' => $tag]) ?>
                            </li>
                        <?php endforeach;?>
                    </ul>
                    <div class="news-date"><i class="fa fa-comments-o"></i> Комментариев: <?= $post["comments"] ?>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- /Idea -->

            <?php if($post["comments"] > 10) : ?>
                <br/>
                <div class="text-center">
                    <a class="btn btn-default" id="but-comm" title="Добавить комментарий" href="#comm">Добавить комментарий</a>
                </div>
            <?php endif; ?>

            <!-- Comments -->
            <div class="comments">
                <div id="comments-list">

                    <?php foreach ($comments as $com) : ?>

                        <div class="comment-block">
                            <img src="/src/avatar.jpg"/>

                            <div class="comment-info">
                                <p class="small-p"><span><?= $com["firstname"] ?></span></p>
                                <p class="small-p"><?= $com["date_created"] ?></p>
                            </div>

                            <div class="comment-text">
                                <p><?= $com["text"] ?></p>
                            </div>

                        </div>

                    <?php endforeach;?>

                </div>

                <?php if (Yii::$app->session->hasFlash('commentAddSubmitted')): ?>

                    <div class="alert alert-success text-center">
                        Спасибо, <?= Yii::$app->user->identity->firstname ?>, комментарий успешно отправлен на модерацию...
                    </div>

                <?php else : ?>

                    <br/><br/>

                <?php endif; ?>

                <?php if (Yii::$app->user->isGuest) : ?>

                    <p><strong><a href="#" onclick="$('#modalFormAuth').modal('show')">Войдите</a>, чтобы оставлять комментарии</strong>.</p>

                <?php else : ?>

                    <?php $form = ActiveForm::begin(); ?>

                    <div id="comm" class="form-group">
                        <?= $form->field($model, 'text')->textarea(['rows' => 5])?>
                    </div>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-2 text-right">{image}</div><div class="col-lg-3">{input}</div></div>',
                        'captchaAction' => 'main/captcha',
                    ]) ?>

                    <div class="form-group submit">
                        <input class="btn btn-default" type="submit" name="comment" value="Добавить"/>
                    </div>

                    <?php ActiveForm::end(); ?>

                <?php endif;?>

            </div>
            <!-- /Comments -->

        </div>

    </div>
</div>
