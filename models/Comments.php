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
 * @property integer $post_id
 * @property integer $user_id
 *
 * @property Posts $post
 * @property Users $user
 *
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
            [['date_created', 'text', 'post_id', 'user_id'], 'required'],
            [['date_created'], 'safe'],
            [['moderated', 'post_id', 'user_id'], 'integer'],
            [['text'], 'string', 'max' => 1000],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Posts::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'post_id' => 'Post ID',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Posts::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }


    public function insertRecord($text, $post_id){
        $this->text = $text;

        $formatter = Yii::$app->formatter;
        $this->date_created = $formatter->asDate('now', 'Y-MM-dd H:i:s');
        $this->post_id = $post_id;
        $this->user_id = Yii::$app->user->identity->getId();

        return $this->save() ? true : false;
    }
}
