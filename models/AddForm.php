<?php

namespace app\models;

use yii\base\Model;

class AddForm extends Model
{
    public $title;
    public $tags;
    public $text;

    public function rules()
    {
        return [
            ['title', 'required', 'message' => 'Поле «Тема» не должно быть пустым'],
            ['tags', 'required', 'message' => 'Необходимо выбрать «Категорию»'],
            ['text', 'required', 'message' => 'Поле «Описание» не должно быть пустым'],
            ['title', 'unique', 'targetClass' => 'app\models\Posts', 'message' => 'Такая идея уже есть'],
            ['title', 'string', 'max' => 128],
            ['text', 'string', 'max' => 3000],
            //['tags', 'in', 'range' => [1, 2, 3], 'allowArray' => true],
        ];
    }
}