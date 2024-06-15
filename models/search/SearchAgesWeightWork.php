<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\work\AgesWeightWork;

/**
 * SearchAgesWeightWork represents the model behind the search form of `app\models\work\AgesWeightWork`.
 */
class SearchAgesWeightWork extends AgesWeightWork
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ages_interval_id'], 'integer'],
            [['self_weight', 'sport_weight', 'game_weight', 'education_weight', 'recreation_weight'], 'number'],
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
        $query = AgesWeightWork::find();

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
            'self_weight' => $this->self_weight,
            'sport_weight' => $this->sport_weight,
            'game_weight' => $this->game_weight,
            'education_weight' => $this->education_weight,
            'recreation_weight' => $this->recreation_weight,
            'ages_interval_id' => $this->ages_interval_id,
        ]);

        return $dataProvider;
    }
}
