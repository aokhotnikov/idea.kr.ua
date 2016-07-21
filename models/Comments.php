<?php

namespace app\models;

use yii;
use yii\base\Model;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "comments".
 *
 * @property integer $id
 * @property string $author_id
 * @property integer $post_id
 * @property string $comment
 * @property string $time
 */
class Comments extends ActiveRecord
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
            [['comment'], 'required'],
            [['id'], 'integer'],
            [['post_id'],'integer'],
            [['time'], 'safe'],
            [['author_id'], 'integer', 'max' =>40],
            [['comment'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
//    public function attributeLabels()
//    {
//        return [
//            'id' => 'ID',
//            'author_id' => 'Author_id',
//            'post_id' => 'Post_id',
//            'text' => 'Text',
//            'time' => 'Time',
//        ];
//
//    }

    
}
