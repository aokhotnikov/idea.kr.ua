<?php

namespace app\controllers;

use Yii;
use yii\db\Query;

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

}
