<?php

namespace app\controllers;

use app\models\Posts;
use yii\data\ActiveDataProvider;
use Yii;
use yii\web\HttpException;

class AdminController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin) {
                return true;
            }
            throw new HttpException(404 ,'Page not found');
        } else {
            return false;
        }
    }

    public function actionIndex($sort = 1)
    {

        $query = Posts::find()->select('id, date_publ, title')->orderBy('date_publ desc');

        if ($sort == 1)
            $query->andWhere('status = "new"');
        elseif ($sort == 2)
            $query->andWhere('status = "isApproved"');
        elseif ($sort == 3) {
            $query->andWhere('status = "isRejected"');
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);
        return $this->render('index', ['model' => $provider, 'activeLabelIdeaSort' => $sort]);
    }

}
