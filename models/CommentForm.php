<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * CommentForm is the model behind the comment form.
 */
class CommentForm extends Model
{
    public $text;
    public $verifyCode;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['text', 'required', 'message' => 'Комментарий не может быть пустым'],
            [['text'], 'string', 'max' => 1000],
            ['verifyCode', 'captcha', 'captchaAction' => 'main/captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Проверочный код:',
            'text' => 'Введите комментарий',
        ];
    }

}
