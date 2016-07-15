<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $pass
 * @property string $salt
 * @property string $email
 * @property integer $isAdmin
 * @property integer $banned
 * @property integer $age
 * @property string $token
 * @property string $auth_key
 * @property string $vk_id
 * @property string $fb_id
 */
class Users extends \yii\db\ActiveRecord
{
    // При регистрации нового пользователя перед сохранением в БД будет генерироваться
    // аутентификационный ключ (Когда пользователь при аутентификации нажмёт "запомнить"
    // пароль", этот ключ запомниться в его куке. В дальнейшем при заходе на сайт ключ из
    // куки будет сравниваться с ключём из БД)
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['isAdmin', 'age', 'banned'], 'integer'],
            [['firstname', 'lastname'], 'string', 'max' => 30],
            [['pass', 'email'], 'string', 'max' => 50],
            [['salt'], 'string', 'max' => 10],
            [['token'], 'string', 'max' => 256],
            [['auth_key'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'pass' => 'Пароль',
            'salt' => 'Соль',
            'email' => 'Email',
            'isAdmin' => 'Админ',
            'banned' => 'Бан',
            'age' => 'Возраст',
            'token' => 'Токен',
            'auth_key' => 'Аутентификационный код',
            'fb_id' => 'Facebook код',
            'vk_id' => 'Vkontakte код',
        ];
    }

    public function insertRecord($arrayAttributes)
    {
        $this->firstname = $arrayAttributes["fname"];
        $this->lastname = $arrayAttributes["lname"];
        $this->email = $arrayAttributes["email"];
        $this->age = $arrayAttributes["age"];
        $this->salt = Yii::$app->getSecurity()->generateRandomString(10);
        $this->pass = md5($arrayAttributes["pass"] . $this->salt);

        if ($this->save()) {
            $user = UserIdentity::findByEmail($this->email);
            Yii::$app->user->login($user, 0);
            return true;
        }
        return false;
    }

}
