<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\work\QuestionnaireWork;

/**
 * SearchQuestionnaireWork represents the model behind the search form of `app\models\work\QuestionnaireWork`.
 */
class SearchQuestionnaireWork extends QuestionnaireWork
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'ages_interval_id', 'sport_tendency', 'recreation_tendency', 'game_tendency', 'education_tendency', 'territory_id'], 'integer'],
            [['arrangement_matrix'], 'safe'],
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
        $query = QuestionnaireWork::find();

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
            'user_id' => $this->user_id,
            'ages_interval_id' => $this->ages_interval_id,
            'sport_tendency' => $this->sport_tendency,
            'recreation_tendency' => $this->recreation_tendency,
            'game_tendency' => $this->game_tendency,
            'education_tendency' => $this->education_tendency,
            'territory_id' => $this->territory_id,
        ]);

        $query->andFilterWhere(['like', 'arrangement_matrix', $this->arrangement_matrix]);

        return $dataProvider;
    }
}
