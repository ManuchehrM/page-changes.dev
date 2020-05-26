<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Log;

/**
 * LogSearch represents the model behind the search form of `app\models\Log`.
 */
class LogSearch extends Log
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'updated_by', 'page_id', 'status'], 'integer'],
            [['updated_at', 'update_description'], 'safe'],
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
    public function search($params)
    {
        $query = Log::find();

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

        $dates = explode(' - ', $_GET['date_range_1']);
        $start_date = $dates[0];
        $end_date = $dates[1];

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'page_id' => $this->page_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'update_description', $this->update_description]);
        $query->andFilterWhere(['>=', 'DATE(updated_at)', $start_date]);
        $query->andFilterWhere(['<=', 'DATE(updated_at)', $end_date]);

        return $dataProvider;
    }
}
