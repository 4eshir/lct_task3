<?php

namespace app\models\search;

use app\components\analytic\ObjectAnalytic;
use yii\base\BaseObject;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\work\ObjectWork;

/**
 * SearchObjectWork represents the model behind the search form of `app\models\work\ObjectWork`.
 */
class SearchObjectWork extends ObjectWork
{
    public $flType;
    public $targetId;
    public $excludeCreators;
    public $includeCreators;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'length', 'width', 'height', 'created_time', 'install_time', 'worker_count', 'object_type_id', 'dead_zone_size', 'flType', 'targetId'], 'integer'],
            [['name', 'creator', 'style', 'model_path', 'excludeCreators', 'includeCreators'], 'safe'],
            [['cost'], 'number'],
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
        $query = ObjectWork::find();

        // add conditions that should always apply here

        $this->load($params);

        if ($this->flType !== '' && $this->targetId !== '') {
            $analyticModel = new ObjectAnalytic();

            try {
                $query = $analyticModel->findSimilarObjects(ObjectWork::findOne(['id' => $this->targetId]), $this->flType);
            }
            catch (\Exception $e) {
                $query = ObjectWork::find();
            }
        }

        if ($this->excludeCreators !== '' && gettype($this->excludeCreators) == 'array') {
            $query = $query->andWhere(['NOT IN', 'creator', $this->excludeCreators]);
        }

        if ($this->includeCreators !== '' && gettype($this->includeCreators) == 'array') {
            $query = $query->andWhere(['IN', 'creator', $this->includeCreators]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'cost' => $this->cost,
            'created_time' => $this->created_time,
            'install_time' => $this->install_time,
            'worker_count' => $this->worker_count,
            'object_type_id' => $this->object_type_id,
            'dead_zone_size' => $this->dead_zone_size,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'creator', $this->creator])
            ->andFilterWhere(['like', 'style', $this->style])
            ->andFilterWhere(['like', 'model_path', $this->model_path]);


        return $dataProvider;
    }
}
