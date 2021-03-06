<?php

namespace common\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "reader_card".
 *
 * @property int $id
 * @property int $book_id
 * @property int $reader_id
 * @property int $employee_id
 * @property string $date_operation
 * @property string $date_return
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Books $book
 * @property User $employee
 * @property User $reader
 */
class ReaderCard extends \yii\db\ActiveRecord
{
    /**
     * Книга возвращена
     */
    const STATUS_RETURNED = 1;

    /**
     * Книга не возвращена
     */
    const STATUS_NOT_RETURNED = 0;

    /**
     * название статусов
     */
    private static $_status = [
        self::STATUS_RETURNED => 'Возвращена',
        self::STATUS_NOT_RETURNED => 'Не возвращена',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reader_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['book_id', 'reader_id', 'employee_id', 'status'], 'integer'],
            [['book_id', 'reader_id', 'employee_id'], 'required'],
            [['date_operation', 'date_return', 'created_at', 'updated_at'], 'safe'],
            [['book_id'], 'exist', 'skipOnError' => true, 'targetClass' => Books::className(), 'targetAttribute' => ['book_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['reader_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['reader_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'status' => 'Статус',
            'book_id' => 'Книга',
            'reader_id' => 'Читатель',
            'employee_id' => 'Сотрудник',
            'date_operation' => 'Дата выдачи',
            'date_return' => 'Дата возврата',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата редактирования',
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Books::className(), ['id' => 'book_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReader()
    {
        return $this->hasOne(User::className(), ['id' => 'reader_id']);
    }

    /**
     * Проверить является вренул ли читатель книгу в срок
     * @return  true если задолжал
     */
    public function isOwesBook()
    {
        if (!$this->status && (date('Y-m-d') > $this->date_return)) {
            return true;
        } 
        return false;
    }

    /**
     * Получить имя статуса
     * @return string
     */
    public function getStatusName()
    {
        return self::$_status[$this->status];
    }

    public function prolongBook() 
    {
        $date = new \DateTime($this->date_return);
        $date->modify('+7 days');
        $this->date_return = $date->format('Y-m-d H:i:s');
        return $this->save();
    }

    public function takeBook() 
    {
        $this->status = self::STATUS_RETURNED;
        return $this->save();
    }
}
