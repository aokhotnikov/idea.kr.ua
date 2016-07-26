<?php

namespace app\controllers;

use app\models\CommentForm;
use app\models\Comments;
use app\models\Posts;
use app\models\Votes;
use Yii;

class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        if($id) {

            $model = new CommentForm();

            if ($model->load(Yii::$app->request->post()) && $model->validate()) {

                $record = new Comments();//model

                if ($record->insertRecord($model->text, $id)) {
                    Yii::$app->session->setFlash('commentAddSubmitted'); //Flash message
                    return $this->refresh();
                }
            }

            $post = Yii::$app->db->createCommand('
                SELECT p.*, u.firstname, GROUP_CONCAT(t.name ORDER BY t.name ASC SEPARATOR ",") AS tags,
                      (SELECT count(*) FROM comments c
		               WHERE c.post_id = p.id AND c.moderated = 1) AS comments
                FROM users u, posts p, tags t, tags_posts tp
                WHERE p.user_id = u.id AND p.id = tp.post_id AND t.id = tp.tag_id AND p.id = :id')->bindValue(':id', $id)->queryOne();

            //echo '<pre>';print_r($post);echo '</pre>';die; // for debag

            $comments = Yii::$app->db->createCommand('
                SELECT c.*, u.firstname FROM comments c, users u
                WHERE c.user_id = u.id AND moderated = 1 AND post_id = :id
                ORDER BY c.date_created')->bindValue(':id', $id)->queryAll();

            return $this->render('index', ['post' => $post, 'comments' => $comments, 'model' => $model]);
        }
        return $this->goBack();
    }

    public function actionAddVote($vote, $post_id)
    {
        if (!Yii::$app->user->isGuest) {

            $user_id = Yii::$app->user->identity->getId();

            if (!Votes::find()->where('user_id = '.$user_id.' and post_id = '.$post_id)->one()) {//пользователь ещё не проголосовал
                $model = new Votes();
                $model->post_id = $post_id;
                $model->user_id = $user_id;
                $model->like_id = $vote;
                if ($model->save()) {
                    $idea = Posts::findOne($post_id);
                    $idea->updateCounters($vote ? ['like' => 1] : ['dislike' => 1]);
                    return true;
                }
            }
            return false;
        }
    }

}
