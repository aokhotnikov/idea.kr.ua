<?php

namespace app\models;

use Yii;
use yii\base\Model;


class EmailForm extends Model
{
    public $email;

    public function rules()
    {
        return [

            ['email', 'required', 'message' => 'E-mail не должен быть пустым'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => 'Введённый E-mail не является правильным'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Введите ваш E-mail:',
        ];
    }

    public function checkAddEmail()
    {
        if ($this->validate()) {
            $id = Yii::$app->user->identity->getId();
            if (($user = Users::findOne($id)) !== null) {
                //echo "<pre>";print_r($user);echo "</pre>";die;
                $user->email = $this->email;
                if ($user->save()) {
                    return true;
                }
            }
        }
        return false;
    }

}
