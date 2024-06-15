<?php

namespace app\models\forms;

use app\components\arrangement\TerritoryConcept;
use app\facades\TerritoryFacade;
use app\helpers\MathHelper;
use app\models\work\ObjectWork;
use app\models\work\QuestionnaireWork;
use app\models\work\TerritoryWork;
use Yii;
use yii\base\Model;

class ConstructorTerritoryForm extends Model
{
    public TerritoryFacade $facade;
    public $territoriesCountByGenerateType = [];
    public $averageMindset = [];
    public $territoryId;

    public function __construct($tId, $config = [])
    {
        parent::__construct($config);
        $this->territoryId = $tId;
        $this->setTerritoriesCountByGenerateType();
        $this->setAverageMindset();
        $this->facade = Yii::createObject(TerritoryFacade::class);
    }


    public function setTerritoriesCountByGenerateType()
    {
        $query = (new \yii\db\Query())
            ->select(['generate_type', 'COUNT(*) AS count'])
            ->from('arrangement')
            ->where(['territory_id' => $this->territoryId])
            ->groupBy('generate_type');

        $this->territoriesCountByGenerateType[TerritoryConcept::TYPE_BASE_WEIGHTS] =
            $query->andWhere(['generate_type' => TerritoryConcept::TYPE_BASE_WEIGHTS])->one() ?
            (int)$query->andWhere(['generate_type' => TerritoryConcept::TYPE_BASE_WEIGHTS])->one()['count'] : 0;

        $query = (new \yii\db\Query())
            ->select(['generate_type', 'COUNT(*) AS count'])
            ->from('arrangement')
            ->where(['territory_id' => $this->territoryId])
            ->groupBy('generate_type');

        $this->territoriesCountByGenerateType[TerritoryConcept::TYPE_CHANGE_WEIGHTS] =
            $query->andWhere(['generate_type' => TerritoryConcept::TYPE_CHANGE_WEIGHTS])->one() ?
            (int)$query->andWhere(['generate_type' => TerritoryConcept::TYPE_CHANGE_WEIGHTS])->one()['count'] : 0;

        $query = (new \yii\db\Query())
            ->select(['generate_type', 'COUNT(*) AS count'])
            ->from('arrangement')
            ->where(['territory_id' => $this->territoryId])
            ->groupBy('generate_type');

        $this->territoriesCountByGenerateType[TerritoryConcept::TYPE_SELF_VOTES] =
            $query->andWhere(['generate_type' => TerritoryConcept::TYPE_SELF_VOTES])->one() ?
            (int)$query->andWhere(['generate_type' => TerritoryConcept::TYPE_SELF_VOTES])->one()['count'] : 0;
    }

    public function getMaxTerritoriesCount()
    {
        return array_keys($this->territoriesCountByGenerateType, max($this->territoriesCountByGenerateType))[0];
    }

    public function setAverageMindset()
    {
        $sets = QuestionnaireWork::find()->where(['territory_id' => $this->territoryId])->all();

        $recreation = 0;
        $sport = 0;
        $education = 0;
        $game = 0;
        foreach ($sets as $set) {
            /** @var QuestionnaireWork $set */
            $recreation += $set->recreation_tendency;
            $sport += $set->sport_tendency;
            $education += $set->education_tendency;
            $game += $set->game_tendency;
        }

        $result = MathHelper::rationing([$recreation, $sport, $education, $game], 100, 0);
        $this->averageMindset[ObjectWork::TYPE_RECREATION] = $result[0];
        $this->averageMindset[ObjectWork::TYPE_SPORT] = $result[1];
        $this->averageMindset[ObjectWork::TYPE_EDUCATION] = $result[2];
        $this->averageMindset[ObjectWork::TYPE_GAME] = $result[3];
    }

    public function generatePriorityArrangement()
    {
        $votes = [];
        if ($this->getMaxTerritoriesCount() == TerritoryConcept::TYPE_SELF_VOTES) {
            foreach ($this->averageMindset as $one) {
                $votes[] = $one;
            }
        }

        return $this->facade->generateTerritoryArrangement($this->getMaxTerritoriesCount(), $this->territoryId, $votes);
    }

    public function getSize()
    {
        $territory = TerritoryWork::find()->where(['id' => $this->territoryId])->one();
        return json_encode([
            'width' => ObjectWork::convertDistanceToCells($territory->width, TerritoryConcept::STEP),
            'length' => ObjectWork::convertDistanceToCells($territory->length, TerritoryConcept::STEP),
        ]);
    }
}