<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $date_created
 * @property string $text
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
}
