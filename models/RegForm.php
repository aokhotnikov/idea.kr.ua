<?php

namespace app\models;

use yii\base\Model;

class RegForm extends Model
{
    public $fname;
    public $lname;
    public $email;
    public $pass;
    public $repass;
    public $age;

    public function rules()
    {
        return [
            ['fname', 'required', 'message' => 'Поле «Имя» не должно быть пустым'],
            ['lname', 'required', 'message' => 'Поле «Фамилия» не должно быть пустым'],
            ['pass', 'required', 'message' => 'Поле «Пароль» не должно быть пустым'],
            ['repass', 'required'],
            ['email', 'required', 'message' => 'Поле «E-mail» не должно быть пустым'],
            ['email', 'unique', 'targetClass' => 'app\models\Users', 'message' => 'Такой E-mail уже есть'],

            ['age', 'integer', 'message' => 'Значение «Возраст» должно быть целым числом'],
            ['email', 'email'],
            ['pass', 'string', 'min' => 6, 'tooShort' => 'Пароль должен содержать минимум 6 символов'],
            [['fname', 'lname'], 'string', 'max' => 30],
            [['pass', 'email', 'repass'], 'string', 'max' => 50],
            ['repass', 'compare', 'compareAttribute' => 'pass'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'repass' => 'Подтвердите пароль',
        ];
    }
}