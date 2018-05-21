<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $name
 * @property string $author
 * @property string $genre
 * @property string $publishing
 * @property string $public_date
 * @property int $pages
 * @property int $department_id
 * @property int $rack_id
 * @property int $count
 * @property string $created_at
 * @property string $updated_at
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * Список жанров книг
     * @var array
     */
    private $genre = [
        0 => 'Саморазвитие',
        1 => 'Cоциология',
        2 => 'Спорт',
        3 => 'Справочники',
        4 => 'Строительство и ремонт',
        5 => 'Фантастика',
        6 => 'Наука',
        7 => 'Детектив',
        8 => 'Роман'
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'author', 'public_date', 'code'], 'required'],
            [['pages', 'department_id', 'rack_id', 'count'], 'integer'],
            [['name', 'author', 'genre', 'publishing', 'public_date', 'description'], 'string', 'max' => 255],
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
            'author' => 'Автор',
            'genre' => 'Жанр',
            'publishing' => 'Издательство',
            'public_date' => 'Дата публикации',
            'pages' => 'Кол-во страниц',
            'department_id' => 'Отдел',
            'rack_id' => 'Полка',
            'code' => 'Код книги',
            'count' => 'Кол-во экземпляров',
            'created_at' => 'Дата добавления',
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
                'value' => new Expression('NOW()'),
            ],
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
    public function getRack()
    {
        return $this->hasOne(Racks::className(), ['id' => 'rack_id']);
    }

    /**
     * ПОлучить список жанров
     * @return array
     */
    public function geSelectGenre()
    {
        return $this->genre;
    }

    /**
     * Получить все коды книг
     * @return array
     */
    public static function getArrayCode()
    {
        return self::find()->select('code')->asArray()->column();
    }

    /**
     * Получить массив всех отелов
     * @retuern array id->name
     */
    public static function getToSelect()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'code');
    }
}
