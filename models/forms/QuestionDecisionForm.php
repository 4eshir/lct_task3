<?php

namespace app\models\forms;

use app\components\arrangement\TerritoryConcept;
use app\facades\ArrangementModelFacade;
use app\facades\TerritoryFacade;
use Yii;
use yii\base\Model;

class QuestionDecisionForm extends Model
{
    public $decision;

    /** @var ArrangementModelFacade[]  */
    public $territoires = [];

    public function rules()
    {
        return [
            [['decision'], 'required'],
            [['decision'], 'integer'],
        ];
    }

    public function generateVariants(array $votes, $territoryId)
    {
        $facade = Yii::createObject(TerritoryFacade::class);
        $facade->generateTerritoryArrangement(TerritoryConcept::TYPE_BASE_WEIGHTS, $territoryId);
        $facade->correctArrangement(random_int(2, 3));
        $this->territoires[] = $facade->model;

        $facade->generateTerritoryArrangement(TerritoryConcept::TYPE_CHANGE_WEIGHTS, $territoryId);
        $facade->correctArrangement(random_int(2, 3));
        $this->territoires[] = $facade->model;

        $facade->generateTerritoryArrangement(TerritoryConcept::TYPE_SELF_VOTES, $territoryId, TerritoryFacade::OPTIONS_DEFAULT, null, ['votes' => $votes]);
        $facade->correctArrangement(random_int(2, 3));
        $this->territoires[] = $facade->model;
    }
}