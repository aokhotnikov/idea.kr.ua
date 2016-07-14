<!-- ---------------------------Left block----------------------- -->
<div class="ideas-left">
    <h5>Разделы</h5>
    <ul class="ideas-list">
        <li class="<?= Yii::$app->controller->id === 'admin' || Yii::$app->controller->id === 'posts' ? 'active' : ''?>" >
            <a href="/admin/index">Идеи</a>
        </li>
        <li class="<?= Yii::$app->controller->id === 'users' ? 'active' : ''?>" >
            <a href="/users/index">Пользователи</a>
        </li>
<!--        <li class="" >-->
<!--            <a href="/tags/index">Теги</a>-->
<!--        </li>-->
<!--        <li class="" >-->
<!--            <a href="/comments/index">Комментарии</a>-->
<!--        </li>-->
    </ul>
</div>
<!-- /Left block -->