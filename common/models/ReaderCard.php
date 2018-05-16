<?php

namespace common\models;

use Yii;

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
 */
class ReaderCard extends \yii\db\ActiveRecord
{
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
            [['book_id', 'reader_id', 'employee_id'], 'integer'],
            [['date_operation', 'date_return', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => 'Book ID',
            'reader_id' => 'Reader ID',
            'employee_id' => 'Employee ID',
            'date_operation' => 'Date Operation',
            'date_return' => 'Date Return',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
