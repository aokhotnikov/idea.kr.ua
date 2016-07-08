<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class AuthForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],

            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['password', 'string', 'min' => 6],
            ['password', 'validatePassword'],
        ];
    }
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $userRecord = Users::findOne([
                'email' => $this->email
            ]);

            if (!$userRecord || md5($this->password.$userRecord->salt) !== $userRecord->pass) {
                $this->addError($attribute, 'Неправильно введены email или пароль');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $user = UserIdentity::findByEmail($this->email);
            //var_dump($user);die;
            return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

}
