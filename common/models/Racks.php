<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "racks".
 *
 * @property int $id
 * @property string $name
 */
class Racks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'racks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
            ['department_id', 'integer']
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
            'department_id' => 'Отдел',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Departments::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasMany(Books::className(), ['rack_id' => 'id']);
    }

    /**
     * Получить массив полок по отделу
     * @param  $departmentId Id
     * @return array id->name
     */
    public static function getToSelectByDepartment($departmentId)
    {
        return ArrayHelper::map(self::find()->where(['department_id' => $departmentId])->all(), 'id', 'name');
    }
}
