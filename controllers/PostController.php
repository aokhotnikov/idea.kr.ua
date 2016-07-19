<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use app\models\Comments;


class PostController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $id = Yii::$app->request->get('id');
        if($id) {
            $query = Yii::$app->db->createCommand('
                select p.*, u.firstname, GROUP_CONCAT(DISTINCT t.name ORDER BY t.name ASC SEPARATOR ",") AS tags
                from users u, posts p, tags t, tags_posts tp
                where p.user_id = u.id and p.id = tp.post_id and t.id = tp.tag_id and p.id=:id 
			    group by p.id')->bindValue(':id', $id)->queryOne();
            //echo '<pre>';print_r($query);echo '</pre>';die; // for debag
            return $this->render('index', ['post' => $query]);
        }
        return $this->goBack();
    }
    public function actionComments()
    {
        $id = Yii::$app->request->get('id');
        $one = 1;
        $com = (new Query())
            ->select('c.post_id, count(*) as num')
            ->from('comments c')
            ->where('c.post_id = '.$id.' and c.is_moderate = '.$one.'')->all();
        if($com[0]["num"]==0){
            $query = Yii::$app->db->createCommand('
                select  p.* 
                from  posts p
                where  p.id='.$id.'
                
			    ')->queryAll();
            return $this->render('comments', ['post' => $query]);
        }
        if($id) {
            $query = Yii::$app->db->createCommand('
                select c.*, p.*, u.* 
                from comments c ,users u, posts p
                where c.is_moderate = 1 and p.id = c.post_id and c.author_id = u.id and p.id='.$id.'
                ORDER BY c.time DESC
			    ')->queryAll();
            return $this->render('comments', ['post' => $query]);
        }


        return $this->goBack();
    }
    public function actionSubmit()
    {
        $model = new Comments();
        $model->load(Yii::$app->request->post());
        $model->time = Yii::$app->formatter->asDate('now', 'Y-MM-dd H:i:s');
        $model->author_id = Yii::$app->user->identity->getId();
        $model->is_moderate = 0;
        $model->save();

        $query = Yii::$app->db->createCommand('
                select c.*, p.*, u.*
                from comments c ,users u, posts p
                where c.is_moderate = 1 and p.id = c.post_id and c.author_id = u.id and p.id='.$model->post_id.'
                ORDER BY c.time DESC
			    ')->queryAll();
        if($query == null) {
            $query = Yii::$app->db->createCommand('
                select  p.* 
                from  posts p
                where  p.id=' . $model->post_id . '
                
			    ')->queryAll();

            return $this->render('comments', ['post' => $query]);
        }

        return $this->render('comments', ['post' => $query]);

    }


}
