<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Статусы юзеров
     */
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * Роли пользователей
     */
    const ROLE_READER = 1;
    const ROLE_EMPLOYEE = 2;

    private static $role_list = [
        self::ROLE_READER => 'Читатель',
        self::ROLE_EMPLOYEE => 'Библиотекарь',
    ];

    /**
     * Список статусов
     * @var array
     */
    private static $status = [
        self::STATUS_ACTIVE => 'Активный',
        self::STATUS_BLOCKED => 'Заблокированный',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'integer'],
            /*[['password_hash', 'username'], 'required'],*/
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['name', 'username', 'surname', 'lastname', 'email', 'address', 'phone', 'password_hash', 'password_reset_token', 'pasport'], 'string', 'max' => 255],
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
            'name' => 'Имя',
            'username' => 'Логин',
            'surname' => 'Фамилия',
            'lastname' => 'Отчество',
            'email' => 'Email',
            'birthday' => 'Дата рождения',
            'role' => 'Роль',
            'status' => 'Статус',
            'address' => 'Адрес',
            'phone' => 'Телефон',
            'auth_key' => 'Auth Key',
            'pasport' => 'Паспорт',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'created_at' => 'Дата регистрации',
            'updated_at' => 'Дата обновления',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Получить массив названий ролей
     * @return array
     */
    public static function getListRole()
    {
        return self::$role_list;
    }

    /**
     * ПОлучить список стутусов
     * @return array
     */
    public function geSelectStatus()
    {
        return self::$status;
    }

    /**
     * Получить название роли
     * @return string
     */
    public function getRoleName()
    {
        return self::$role_list[$this->role];
    }

    /**
     * Получить название статуса
     * @return string
     */
    public function getStatusName()
    {
        return self::$status[$this->status];
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Получить все коды книг
     * @return array
     */
    public static function getArrayLogin()
    {
        return self::find()->select('username')->asArray()->column();
    }

    /**
     * Получить массив всех отелов
     * @retuern array id->name
     */
    public static function getToSelect()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'username');
    }

    /**
     * Проверить ползователя если он работник
     * @return boolean [description]
     */
    public function isEmployee()
    {
        return $this->role == self::ROLE_EMPLOYEE;
    }

    /**
     * Количество книг в библиотеке
     */
    public static function getCountBockToBiblio($username)
    {
        $user = self::find()->where(['username' => $username])->one();
        return \common\models\ReaderCard::find()->where(['reader_id' => $user->id])->andWhere(['status' => ReaderCard::STATUS_NOT_RETURNED])->count() < 5;
    }
}
