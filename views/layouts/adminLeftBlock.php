<!-- ---------------------------Left block----------------------- -->
<div class="ideas-left">
    <h5>Разделы</h5>
    <ul class="ideas-list">
        <li class="<?= Yii::$app->controller->id === 'posts' ? 'active' : ''?>" >
            <a href="/posts/index">Идеи</a>
        </li>
        <li class="<?= Yii::$app->controller->id === 'users' ? 'active' : ''?>" >
            <a href="/users/index">Пользователи</a>
        </li>
        <li class="<?= Yii::$app->controller->id === 'comments' ? 'active' : ''?>" >
            <a href="/comments/index">Комментарии</a>
        </li>
        <!--        <li class="" >-->
        <!--            <a href="/tags/index">Теги</a>-->
        <!--        </li>-->
    </ul>
</div>
<!----------------------------- /Left block ------------------------->