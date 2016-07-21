<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments_posts".
 *
 * @property integer $id
 * @property integer $com_id
 * @property integer $post_id
 *
 * @property Comments $com
 * @property Posts $post
 */
class CommentsPosts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_id', 'post_id'], 'required'],
            [['com_id', 'post_id'], 'integer'],
            [['com_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['com_id' => 'id']],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'com_id' => 'Com ID',
            'post_id' => 'Post ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCom()
    {
        return $this->hasOne(Comments::className(), ['id' => 'com_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    public function insertRecord($com_id, $post_id)
    {
        $this->com_id = $com_id;
        $this->post_id = $post_id;

        return $this->save() ? true : false;
    }
}
