<?php

namespace frontend\modules\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReaderCard;

/**
 * ReaderCardSearch represents the model behind the search form of `common\models\ReaderCard`.
 */
class ReaderCardSearch extends ReaderCard
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'book_id', 'reader_id', 'employee_id', 'status'], 'integer'],
            [['date_operation', 'date_return', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $status)
    {
        $query = ReaderCard::find();
        if ($status == 'no_return' || $status == 'ower') {
            $query->andWhere(['status' => \common\models\ReaderCard::STATUS_NOT_RETURNED]);
            if ($status == 'ower') {
                $query->andWhere(['<', 'date_return', date('Y-m-d')]);
            }
        } elseif ($status == 'return') {
            $query->andWhere(['status' => \common\models\ReaderCard::STATUS_RETURNED]);
        }
            
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'book_id' => $this->book_id,
            'reader_id' => $this->reader_id,
            'employee_id' => $this->employee_id,
            'date_operation' => $this->date_operation,
            'date_return' => $this->date_return,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
