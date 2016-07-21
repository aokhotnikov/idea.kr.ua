<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $date_created
 * @property string $text
 * @property integer $moderated
 *
 * @property CommentsPosts[] $commentsPosts
 * @property CommentsUsers[] $commentsUsers
 */
class Comments extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date_created', 'text'], 'required'],
            [['date_created'], 'safe'],
            [['moderated'], 'integer'],
            [['text'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_created' => 'Дата создания',
            'text' => 'Текст',
            'moderated' => 'Просмотрен',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentsPosts()
    {
        return $this->hasMany(CommentsPosts::className(), ['com_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCommentsUsers()
    {
        return $this->hasMany(CommentsUsers::className(), ['com_id' => 'id']);
    }

    public function insertRecord($text, $post_id){
        $this->text = $text;

        $formatter = Yii::$app->formatter;
        $this->date_created = $formatter->asDate('now', 'Y-MM-dd H:i:s');

        if ($this->save()){
            $modelCommentsPosts = new CommentsPosts(); // добавляю связки в таблицу "Comments_posts"
            $modelCommentsUsers = new CommentsUsers(); // добавляю связки в таблицу "Comments_users"
            if ($modelCommentsPosts->insertRecord($this->id, $post_id) &&
                $modelCommentsUsers->insertRecord($this->id, Yii::$app->user->identity->getId())) {
                return true;
            }
        }
        return false;
    }
}
