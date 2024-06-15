<?php


namespace app\models\forms;


use app\components\arrangement\TerritoryArrangementManager;
use app\components\arrangement\TerritoryConcept;
use app\models\work\AgesWeightChangeableWork;
use app\models\work\AgesWeightWork;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;
use Yii;

class GenerateArrangementForm
{
    public $sportCoef;
    public $gameCoef;
    public $educationalCoef;
    public $recreationCoef;

    public $genType;

    /**
     * Генерация матрицы размещения объектов на территории
     * * 0 - в "ячейке" ничего нет
     * * ID - объект с идентификатором ID
     * @param TerritoryWork $territory объект, описывающий конкретную территорию
     * @return int|void
     */
    public function generate(TerritoryWork $territory)
    {
        $concept = Yii::createObject(TerritoryArrangementManager::class);

        switch ($this->genType) {
            case TerritoryConcept::TYPE_BASE_WEIGHTS:
                return $this->generateBase($territory, $concept);
            case TerritoryConcept::TYPE_CHANGE_WEIGHTS:
                return $this->generateChange($territory, $concept);
            case TerritoryConcept::TYPE_SELF_VOTES:
                return $this->generateVotes($territory, $concept);
            default:
                return -1;
        }
    }

    // генерация на базовых весах по возрастам
    private function generateBase(TerritoryWork $territory, TerritoryArrangementManager $concept)
    {
        $weights = AgesWeightWork::find()->orderBy(['ages_interval_id' => SORT_ASC])->all();
        $objects = ObjectWork::find()->where(['<=', 'length', $territory->length])->andWhere(['<=', 'width', $territory->width])->all();

        while (!$concept->isFilled()) {
            $concept->setSuitableObject($objects, $weights);
        }
    }

    // генерация на измененных весах по возрастам
    private function generateChange(TerritoryWork $territory, TerritoryArrangementManager $concept)
    {
        $weights = AgesWeightChangeableWork::find()->orderBy(['ages_interval_id' => SORT_ASC])->andWhere(['territory_id' => $territory->id])->all();
        $objects = ObjectWork::find()->where(['<=', 'length', $territory->length])->andWhere(['<=', 'width', $territory->width])->all();

        while (!$concept->isFilled()) {
            $concept->setSuitableObject($objects, $weights);
        }
    }

    // генерация на личном голосовании одного пользователя
    private function generateVotes(TerritoryWork $territory, TerritoryConcept $concept)
    {

    }
}