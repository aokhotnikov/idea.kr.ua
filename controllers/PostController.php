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

            $query = (new Query())
                ->select('posts.*, users.firstname')
                ->from('users, posts')
                ->where('posts.user_id = users.id and posts.id='.$id)
                ->one();
            //echo '<pre>';print_r($query);echo '</pre>';die; // for debag
            return $this->render('index', ['post' => $query]);
        }
        return $this->goBack();
    }

}
