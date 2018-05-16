<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $surname
 * @property string $lastname
 * @property string $password
 * @property string $email
 * @property string $birthday
 * @property int $role
 * @property string $address
 * @property string $phone
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $created_at
 * @property string $updated_at
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['password', 'email', 'auth_key', 'password_hash'], 'required'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['role'], 'integer'],
            [['name', 'username', 'surname', 'lastname', 'password', 'email', 'address', 'phone', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'username' => 'Username',
            'surname' => 'Surname',
            'lastname' => 'Lastname',
            'password' => 'Password',
            'email' => 'Email',
            'birthday' => 'Birthday',
            'role' => 'Role',
            'address' => 'Address',
            'phone' => 'Phone',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
