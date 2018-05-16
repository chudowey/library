<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "departments".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 */
class Departments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'departments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'address' => 'Адрес',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRacks()
    {
        return $this->hasMany(Racks::className(), ['department_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasMany(Books::className(), ['department_id' => 'id']);
    }

    /**
     * Получить массив всех отелов
     * @retuern array id->name
     */
    public static function getToSelect()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
