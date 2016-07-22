<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->firstname . " " . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($this->title) ?></h3>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'firstname',
        'lastname',
        'pass',
        'salt',
        'email:email',
        'isAdmin',
        'banned',
        'age',
        'token',
        'auth_key',
        'vk_id',
        'fb_id',
    ],
]) ?>
<p>
    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

    <?php if ($model->banned) :?>

        <?= Html::a('Разбанить', ['change-ban', 'id' => $model->id, 'ban' => 0], [
            'class' => 'btn btn-success',
        ]) ?>

    <?php else : ?>

        <?= Html::a('Забанить', ['change-ban', 'id' => $model->id, 'ban' => 1], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите забанить пользователя?',
            ],
        ]) ?>

    <?php endif; ?>

</p>
