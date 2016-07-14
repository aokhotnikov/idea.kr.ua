<?php

namespace app\models;

use yii\base\Model;

class AddForm extends Model
{
    public $title;
    public $tags;
    public $text;
    public $verifyCode;

    public function rules()
    {
        return [
            ['title', 'required', 'message' => 'Поле «Тема» не должно быть пустым'],
            ['text', 'required', 'message' => 'Поле «Описание» не должно быть пустым'],
            ['title', 'unique', 'targetClass' => 'app\models\Posts', 'message' => 'Такая идея уже есть'],
            ['title', 'string', 'max' => 128],
            ['text', 'string', 'max' => 3000],
            ['verifyCode', 'captcha', 'captchaAction' => 'main/captcha'],
        ];
    }
}