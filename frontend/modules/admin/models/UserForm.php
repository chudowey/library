<?php

namespace frontend\modules\admin\models;

use \Yii;
use \common\models\User;

/**
 * Class UserForm
 * @package backend\models\forms
 */
class UserForm extends \yii\base\Model
{
    /** @var null|object [Пользователь] */
    public $User = null;
    /** @var null|string [пароль] */
    public $user_password = null;
    /** @var null|string [пароль] */
    public $login = null;

    // сценарий создать
    const SCENARIO_CREATE = 'create';
    // сценарий обновить
    const SCENARIO_UPDATE = 'update';

    /**
     * сценарии валидации
     * @return array
     */
    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['user_password', 'login'],
            self::SCENARIO_UPDATE => ['user_password', 'login']
        ];
    }

    /**
     * Правила валидации
     * @return array
     */
    public function rules()
    {
        return [
            [['user_password'], 'string', 'min' => 6],
            ['login', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_password' => 'Пароль',
            'login' => 'Логин'
        ];
    }

    /**
     * Инициализация формы
     */
    public function init()
    {
        switch ($this->scenario) {
            case self::SCENARIO_CREATE:
                $this->User = new User();
                $userId = User::find()->max('id');
                $this->login = 'user_' . ++$userId;
                $this->user_password = $this->generatePass();
                break;
            case self::SCENARIO_UPDATE:
                $this->user_password = '';
                $this->login = $this->User->username;
                break;
            default:
                throw new \Exception("Не инициализирован сценарий", 1);
                break;
        }
    }

    /**
     * Генерация временного пароля
     * @param  integer $length длина пароля
     * @return $string сгенерированный пароль
     */
    protected function generatePass($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * Сохранение пользовталя
     * @return bool
     */
    public function save($formData)
    {
        if ($this->load($formData)) {
            if ($this->User->load($formData) && $this->User->validate()) {
                if (!empty($this->user_password)) {
                    $this->User->setPassword($this->user_password);
                }
                $this->User->username = $this->login;
                return $this->User->save();
            } return false;   
        } return false;
    }
}
