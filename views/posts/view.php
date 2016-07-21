<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Posts */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="posts-view ideas-center">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'short_text',
            'date_publ',
            [
                'attribute' => 'status',
                'value' => $model->status == 'new' ? 'Новый' : ($model->status == 'isApproved' ? 'Утверждён' : 'Отклонён')
            ],
            [
                'attribute' => 'user_id',
                'value' => $model->getUserFirstname()
            ],
            'like',
            'dislike',
            'text',
            [
                'attribute' => 'completed',
                'value' => $model->completed ? 'Да' : 'Нет'
            ],
        ],
    ]) ?>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

</div>
