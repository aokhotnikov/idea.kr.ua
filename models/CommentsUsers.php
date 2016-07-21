<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comments_users".
 *
 * @property integer $id
 * @property integer $com_id
 * @property integer $user_id
 *
 * @property Users $user
 * @property Comments $com
 */
class CommentsUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['com_id', 'user_id'], 'required'],
            [['com_id', 'user_id'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['com_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['com_id' => 'id']],
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
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCom()
    {
        return $this->hasOne(Comments::className(), ['id' => 'com_id']);
    }

    public function insertRecord($com_id, $user_id)
    {
        $this->com_id = $com_id;
        $this->user_id = $user_id;

        return $this->save() ? true : false;
    }
}
