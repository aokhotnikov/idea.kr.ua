<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comments */

$this->title = 'Просмотр комментария';
$this->params['breadcrumbs'][] = ['label' => 'Комментарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h3><?= Html::encode($this->title) ?></h3>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'date_created',
        'text',
        [
            'attribute' => 'moderated',
            'value' => $model->moderated ? 'Да' : 'Нет'
        ],
    ],
]) ?>

<p>
    <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы действительно хотите удалить комментарий?',
            'method' => 'post',
        ],
    ]) ?>
</p>