<?php

namespace app\controllers;

use app\models\Posts;
use app\models\Votes;
use Yii;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        if($id) {
            $query = Yii::$app->db->createCommand('
                select p.*, u.firstname, GROUP_CONCAT(DISTINCT t.name ORDER BY t.name ASC SEPARATOR ",") AS tags
                from users u, posts p, tags t, tags_posts tp
                where p.user_id = u.id and p.id = tp.post_id and t.id = tp.tag_id and p.id = :id
			    group by p.id')->bindValue(':id', $id)->queryOne();
            //echo '<pre>';print_r($query);echo '</pre>';die; // for debag
            return $this->render('index', ['post' => $query]);
        }
        return $this->goBack();
    }

    public function actionAddVote($vote, $post_id)
    {
        if (!Yii::$app->user->isGuest) {

            $user_id = Yii::$app->user->identity->getId();

            if (Votes::find()->where('user_id = '.$user_id.' and post_id = '.$post_id)->one()) //пользователь уже проголосовал
                return false;
            else {
                $model = new Votes();
                $model->post_id = $post_id;
                $model->user_id = $user_id;
                $model->like_id = $vote;
                if ($model->save()) {
                    $idea = Posts::findOne($post_id);
                    $vote ? $idea->updateCounters(['like' => 1]) : $idea->updateCounters(['dislike' => 1]);
                    return true;
                }
            }
        }
    }

}
