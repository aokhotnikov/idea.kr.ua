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
 * @property integer $user_id
 * @property integer $like
 * @property integer $dislike
 * @property integer $comments
 * @property string $text
 * @property integer $completed
 *
 * @property TagsPosts[] $tagsPosts
 */
class Posts extends \yii\db\ActiveRecord
{
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
            [['short_text'], 'string', 'max' => 500],
            [['tags'], 'string', 'max' => 100],
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
            'title' => 'Title',
            'short_text' => 'Short Text',
            'date_publ' => 'Date Publ',
            'user_id' => 'User ID',
            'like' => 'Like',
            'dislike' => 'Dislike',
            'comments' => 'Comments',
            'text' => 'Text',
            'completed' => 'Completed',
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
        //$this->tags = $this->addTags($formData["tags"]);

        //echo '<pre>';print_r($formData["tags"]);echo '</pre>';die; // for debag

        if ($this->save()) {
            foreach ($formData["tags"] as $tag_id) {
                $model = new TagsPosts(); // добавляю связки в таблицу tags_posts
                if (!$model->insertRecord($this->id, $tag_id + 1)) {
                    return false;
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

    protected function addTags($arrayTags){
        $strTags = '';
        $tags = Tags::find()->orderBy('id')->all();
        $category = ArrayHelper::getColumn($tags, 'name');
        //echo '<pre>';print_r($category);echo '</pre>';die; // for debag

        foreach ($arrayTags as $val){
            if ($strTags === '')
                $strTags .= $category[$val];
            else {
                $strTags .= ",".$category[$val];
            }
        }

        return $strTags;
    }
}
