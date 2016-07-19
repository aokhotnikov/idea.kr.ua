<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property string $title
 * @property string $short_text
 * @property string $date_publ
 * @property string $status
 * @property integer $user_id
 * @property integer $like
 * @property integer $dislike
 * @property integer $comments
 * @property string $text
 * @property integer $completed
 * @property TagsPosts[] $tagsPosts
 */
class Posts extends \yii\db\ActiveRecord
{

    public $tagz;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_text', 'date_publ', 'user_id', 'text'], 'required'],
            [['date_publ'], 'safe'],
            [['user_id', 'like', 'dislike', 'comments', 'completed'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['status'], 'string'],
            [['short_text'], 'string', 'max' => 500],
            [['text'], 'string', 'max' => 3000],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Тема',
            'short_text' => 'Короткий текст',
            'date_publ' => 'Дата создания',
            'status' => 'Статус',
            'user_id' => 'Автор',
            'like' => 'Кол-во Like',
            'dislike' => 'Кол-во Dislike',
            'comments' => 'Кол-во комментариев',
            'text' => 'Текст',
            'completed' => 'Завершён',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagsPosts()
    {
        return $this->hasMany(TagsPosts::className(), ['post_id' => 'id']);
    }

    public function insertRecord($formData)
    {
        $this->title = $formData["title"];

        $formatter = Yii::$app->formatter;
        $this->date_publ = $formatter->asDate('now', 'Y-MM-dd H:i:s');

        $this->text = $formData["text"];
        $this->short_text = $this->makeShortText($this->text);
        $this->user_id = Yii::$app->user->identity->getId();

        //echo '<pre>';print_r($formData["tags"]);echo '</pre>';die; // for debag

        if ($this->save()) {
            if ($formData["tags"]) { //Если пользователь ввёл какие-то теги
                foreach ($formData["tags"] as $tag) {
                    $query = Tags::find()->where(['name' => $tag])->one();
                    $tag_id = $query["id"];
                    if (!$tag_id) { // если в таблице "Tags" нет такого тега
                        //echo '<pre>';print_r($query);echo '</pre>'; // for debag
                        $modelTags = new Tags();
                        $modelTags->name = $tag;
                        $modelTags->save(); //save new tag
                        $tag_id = $modelTags->id;
                    }
                    $modelTagsPosts = new TagsPosts(); // добавляю связки в таблицу "Tags_posts"
                    if (!$modelTagsPosts->insertRecord($this->id, $tag_id)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

    protected function makeShortText($text){
        if(strlen($text) < 500) return $text;
        for ($i = 500; $i > 0; $i--){
            if ($text[$i] === ' ') {
                return $text = substr($text, 0, $i);
            }
        }
    }
}
