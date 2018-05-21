<?php

namespace frontend\modules\admin\models;

use \Yii;
use \common\models\ReaderCard;
use yii\db\Expression;

/**
 * Class UserForm
 * @package backend\models\forms
 */
class ReaderCardForm extends \yii\base\Model
{
    /**
     * Книга
     */
    public $book;

    /**
     * Читатель
     */
    public $reader;

    /**
     * Операция
     */
    public $ReaderCard;

    /**
     * Правила валидации
     * @return array
     */
    public function rules()
    {
        return [
            [['book'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\Books::className(), 'targetAttribute' => ['book' => 'code']],
            [['employee'], 'exist', 'skipOnError' => true, 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['employee' => 'username']],
            [['book', 'reader'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'book' => 'Книга',
            'reader' => 'Читатель'
        ];
    }

    /**
     * Инициализация формы
     */
    public function init()
    {
        $this->ReaderCard = new ReaderCard();
        $startDate = time();
        $this->ReaderCard->date_operation = $startDate;
        $this->ReaderCard->date_return = date('Y-m-d H:i:s', strtotime('+2 week', $startDate));
    }

    /**
     * Сохранение пользовталя
     * @return bool
     */
    public function save($formData)
    {
        $result = false;
        if ($this->load($formData)) {
            $this->ReaderCard->book_id = \common\models\Books::find()->where(['code' => $formData['ReaderCardForm']['book']])->one()->id;
            $this->ReaderCard->reader_id = \common\models\User::find()->where(['username' => $formData['ReaderCardForm']['reader']])->one()->id;
            $this->ReaderCard->employee_id = Yii::$app->user->identity->id;
            if ($this->ReaderCard->load($formData) && $this->ReaderCard->validate() && $this->ReaderCard->save()) {
                $result = true;
            }
        }
        return $result;
    }
}
