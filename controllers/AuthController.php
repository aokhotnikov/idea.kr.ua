<?php

namespace app\controllers;

use app\models\AuthForm;
use yii\web\Response;
use Yii;
use yii\web\Controller;
use yii\widgets\ActiveForm;


class AuthController extends Controller
{
    public function actionLogin()
    {
        $model = new AuthForm();

        //  ----  AJAX валидация  ----
        if(Yii::$app->request->isAjax && Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post())) {//пришли POST данные
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->refresh();
        }

        return $this->goHome();
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
