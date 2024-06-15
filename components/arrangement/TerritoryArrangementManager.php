<?php

namespace app\components\arrangement;

use app\facades\ArrangementModelFacade;
use app\facades\TerritoryFacade;
use app\helpers\MathHelper;
use app\models\ObjectExtended;
use app\models\work\AgesWeightChangeableWork;
use app\models\work\AgesWeightWork;
use app\models\work\ArrangementWork;
use app\models\work\NeighboringTerritoryWork;
use app\models\work\ObjectWork;
use app\models\work\PeopleTerritoryWork;
use app\models\work\TerritoryWork;
use app\models\work\UserWork;
use Yii;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

class TerritoryArrangementManager
{
    public TerritoryConcept $territory;
    public TemplatesManager $template;

    public function __construct(TerritoryConcept $territory, TemplatesManager $template)
    {
        $this->territory = $territory;
        $this->template = $template;
    }

    public function setTerritory(string $generateType, int $territoryId, array $votes = [])
    {
        $territory = TerritoryWork::find()->where(['id' => $territoryId])->one();

        $this->territory = TerritoryConcept::make($territory->length, $territory->width, TerritoryConcept::STEP);
        $cellsCount = $this->territory->widthCellCount * $this->territory->lengthCellCount;

        $this->setTerritoryState($territoryId, $generateType, $cellsCount, $votes);
        $this->territory->setFullnessIntervals(
            [
                'sport' => [0, $this->territory->state->sportPart / 2, $this->territory->state->sportPart / 1.5, $this->territory->state->sportPart / 1.2, $this->territory->state->sportPart],
                'game' => [0, $this->territory->state->gamePart / 2, $this->territory->state->gamePart / 1.5, $this->territory->state->gamePart / 1.2, $this->territory->state->gamePart],
                'recreation' => [0, $this->territory->state->recreationPart / 2, $this->territory->state->recreationPart / 1.5, $this->territory->state->recreationPart / 1.2, $this->territory->state->recreationPart],
                'education' => [0, $this->territory->state->educationPart / 2, $this->territory->state->educationPart / 1.5, $this->territory->state->educationPart / 1.2, $this->territory->state->educationPart],
            ]
        );
    }

    /**
     * @param int $territoryId идентификатор территории
     * @param int $genType тип генерации (базовые веса, измененные веса, личные голоса)
     * @param int $cellsCount количество "ячеек" на площадке
     * @param array $votes необязательный параметр, массив голосов пользователя (пример: [ObjectWork::TYPE_RECREATION => 5, ...])
     */
    public function setTerritoryState($territoryId, $genType, $cellsCount, $votes = [])
    {
        if ($genType == TerritoryConcept::TYPE_SELF_VOTES && count($votes) !== 4) {
            throw new Exception('Некорректно заполнен массив $votes');
        }

        $people = PeopleTerritoryWork::find()->where(['territory_id' => $territoryId])->orderBy(['ages_interval_id' => SORT_ASC])->all();
        $recreationPart = 0;
        $sportPart = 0;
        $educationPart = 0;
        $gamePart = 0;
        $weights = [];

        foreach ($people as $interval) {
            /** @var PeopleTerritoryWork $interval */
            switch ($genType) {
                case TerritoryConcept::TYPE_BASE_WEIGHTS:
                    $weights = AgesWeightWork::find()->where(['ages_interval_id' => $interval->ages_interval_id])->one();
                    break;
                case TerritoryConcept::TYPE_CHANGE_WEIGHTS:
                    $weights = AgesWeightChangeableWork::find()->where(['ages_interval_id' => $interval->ages_interval_id])->andWhere(['territory_id' => $territoryId])->one();
                    break;
                case TerritoryConcept::TYPE_SELF_VOTES:
                    // coming soon
                    break;
                default:
                    throw new \DomainException('Неизвестный тип генерации');
            }

            $this->correctWeightsByNeighbors($territoryId, $weights);

            if ($genType !== TerritoryConcept::TYPE_SELF_VOTES) {
                $recreationPart += $interval->count * $weights->recreation_weight;
                $sportPart += $interval->count * $weights->sport_weight;
                $educationPart += $interval->count * $weights->education_weight;
                $gamePart += $interval->count * $weights->game_weight;
            }

        }

        if ($genType !== TerritoryConcept::TYPE_SELF_VOTES) {
            $recreationPart = round($recreationPart, 2);
            $sportPart = round($sportPart, 2);
            $educationPart = round($educationPart, 2);
            $gamePart = round($gamePart, 2);
        }
        else {
            $recreationPart = round($votes[ObjectWork::TYPE_RECREATION] / 10, 2);
            $sportPart = round($votes[ObjectWork::TYPE_SPORT] / 10, 2);
            $educationPart = round($votes[ObjectWork::TYPE_EDUCATION] / 10, 2);
            $gamePart = round($votes[ObjectWork::TYPE_GAME] / 10, 2);
        }

        $values = MathHelper::rationing([$recreationPart, $sportPart, $educationPart, $gamePart], 1);
        $this->territory->state->fill(
            floor($values[0] * $cellsCount),
            floor($values[1] * $cellsCount),
            floor($values[2] * $cellsCount),
            floor($values[3] * $cellsCount));
    }

    /**
     * @param $object
     * @param $left
     * @param $top
     * @param $position
     */
    public function installObject($object, $left, $top, $position)
    {
        try {
            /** @var ObjectWork $object */

            if (!$this->allowedInstall($object, $left, $top, $position)) {
                throw new \Exception('Здесь нельзя строить!');
            }

            switch ($position) {
                case TerritoryConcept::HORIZONTAL_POSITION:
                    $this->territory->installHorizontalObject($object, $left, $top);
                    break;
                case TerritoryConcept::VERTICAL_POSITION:
                    $this->territory->installVerticalObject($object, $left, $top);
                    break;
                default:
                    throw new \Exception('Неизвестный тип позиционирования');
            }

            $object->convertDimensionsToCells();

            switch ($object->object_type_id) {
                case ObjectWork::TYPE_RECREATION:
                    $this->territory->state->addRecreation($object->lengthCells * $object->widthCells);
                    break;
                case ObjectWork::TYPE_SPORT:
                    $this->territory->state->addSport($object->lengthCells * $object->widthCells);
                    break;
                case ObjectWork::TYPE_EDUCATION:
                    $this->territory->state->addEducation($object->lengthCells * $object->widthCells);
                    break;
                case ObjectWork::TYPE_GAME:
                    $this->territory->state->addGame($object->lengthCells * $object->widthCells);
                    break;
                default:
                    throw new Exception('Неизвестный тип объекта');
            }
        }
        catch (\Exception $e) {
            return false;
        }

        $this->territory->state->addToObjectIds($object->id);
        $this->territory->state->addToObjectsList($object, $left, $top, $position);
    }

    public function removeObject($object, $left, $top, $position)
    {
        /** @var ObjectWork $object */
        $object->convertDimensionsToCells();
        $length = $position == TerritoryConcept::HORIZONTAL_POSITION ? $object->lengthCells : $object->widthCells;
        $width = $position == TerritoryConcept::HORIZONTAL_POSITION ? $object->widthCells : $object->lengthCells;

        for ($i = $top; $i < $top + $width; $i++) {
            for ($j = $left; $j < $left + $length; $j++) {
                //var_dump("[$i,$j] ".$this->territory->matrix[$i][$j]);
                $this->territory->matrix[$i][$j] = 0;
                //var_dump("[$i,$j] ".$this->territory->matrix[$i][$j]);
            }
        }

        // тут надо затирать в матрице объект

        $this->territory->state->deleteObjectById($object->id, $left, $top);
    }

    public function allowedInstall($object, $left, $top, $position, int $templateId = null)
    {
        /** @var ObjectWork $object */
        $control = true;
        $side1 = $position == TerritoryConcept::HORIZONTAL_POSITION ? $object->length : $object->width;
        $side2 = $position == TerritoryConcept::HORIZONTAL_POSITION ? $object->width : $object->length;
        $deadZoneCells = ObjectWork::convertDistanceToCells($object->dead_zone_size, TerritoryConcept::STEP);

        $newTop = $top - $deadZoneCells >= 0 ? $top - $deadZoneCells : 0;
        $newLeft = $left - $deadZoneCells >= 0 ? $left - $deadZoneCells : 0;

        $maxTop = $top + ObjectWork::convertDistanceToCells($side2,TerritoryConcept::STEP);
        $maxTop = $maxTop + $deadZoneCells < count($this->territory->matrix) ? $maxTop + $deadZoneCells : count($this->territory->matrix);
        //$maxTop -= 1;

        $maxLeft = $left + ObjectWork::convertDistanceToCells($side1, TerritoryConcept::STEP);
        $maxLeft = $maxLeft + $deadZoneCells < count($this->territory->matrix[0]) ? $maxLeft + $deadZoneCells : count($this->territory->matrix[0]);
        //$maxLeft -= 1;

        if ($left + ObjectWork::convertDistanceToCells($side1, TerritoryConcept::STEP) > $this->territory->lengthCellCount ||
            $top + ObjectWork::convertDistanceToCells($side2, TerritoryConcept::STEP) > $this->territory->widthCellCount) {
            $control = false;
        }
        else {
            for ($i = $newTop; $i < $maxTop; $i++) {
                for ($j = $newLeft; $j < $maxLeft; $j++) {
                    $additionalCondition = false;
                    if ($templateId) {
                        $templateMatrix = $this->template->getTemplateMatrix();
                        $additionalCondition = $templateMatrix[$i][$j] !== 0 && $templateMatrix[$i][$j] !== $object->object_type_id;
                    }

                    //var_dump('Final: '. $this->territory->matrix[$i][$j] != '0' && !$additionalCondition ? 'true' : 'false');
                    if ($this->territory->matrix[$i][$j] != '0' || $additionalCondition) {
                        $control = false;
                    }
                }
            }
        }

        return $control;
    }

    /**
     * Подставляет в текущую расстановку подходящий объект
     * @param int $addGenType тип генерации @see TerritoryFacade константы OPTIONS
     * @param float|null $referenceUnitCost эталонная средняя удельная стоимость кв. единицы
     * @param int|null $referenceEmptyCells эталонное количество пустых ячеек (кв. единиц)
     * @param ObjectExtended[] $stopListObject список объектов, размещение которых допускается в последнюю очередь
     * @param int|null $templateId ID шаблона расстановки, по которому произвести генерацию
     * @return bool
     * @throws Exception
     */
    public function setSuitableObject(int $addGenType = TerritoryFacade::OPTIONS_DEFAULT, $referenceUnitCost = null, $referenceEmptyCells = null, $stopListObject = [], $templateId = null)
    {
        $cleanStopList = [];
        if ($stopListObject != [])
        {
            /** @var ObjectExtended[] $stopListObject */
            foreach ($stopListObject as $object) {
                $cleanStopList[$object->object->id] = 1;
            }
        }

        $fills = [
            ObjectWork::TYPE_RECREATION => $this->territory->state->fillRecreation,
            ObjectWork::TYPE_SPORT => $this->territory->state->fillSport,
            ObjectWork::TYPE_EDUCATION => $this->territory->state->fillEducation,
            ObjectWork::TYPE_GAME => $this->territory->state->fillGame,
        ];

        $this->territory->state->getSortedFillsDesc($fills);

        $installFlag = false;

        foreach ($fills as $key => $fill) {
            $objectTypeText = 'recreation';
            $fillType = $this->territory->state->fillRecreation;
            if ($key == 2) {
                $objectTypeText = 'sport';
                $fillType = $this->territory->state->fillSport;
            }
            if ($key == 3) {
                $objectTypeText = 'education';
                $fillType = $this->territory->state->fillEducation;
            }
            if ($key == 4) {
                $objectTypeText = 'game';
                $fillType = $this->territory->state->fillGame;
            }

            $objects = ObjectWork::find()
                ->select(['*', 'unit_cost' => new Expression('`cost` / (`length` * `width`)')])
                ->where(['object_type_id' => $key])
                ->andWhere(['NOT IN', 'id', $addGenType !== TerritoryFacade::OPTIONS_BUDGET_ECONOMY ? array_keys($this->territory->state->objectIds) : []]);

            if ($addGenType == TerritoryFacade::OPTIONS_SIMILAR) {
                $objects = $objects->andWhere(['NOT IN', 'id', array_keys($cleanStopList)]);
            }


            if ($addGenType == TerritoryFacade::OPTIONS_BUDGET_ECONOMY) {
                $objects = $objects->orderBy(['unit_cost' => SORT_ASC]);
            }

            $objects = $objects->all();
            arsort($this->territory->state->objectIds);
            $objectIdsCopy = $cleanStopList + $this->territory->state->objectIds;

            while (count($objects) == 0 && count($objectIdsCopy) > 0) {

                $objects = ObjectWork::find()
                    ->select(['*', 'unit_cost' => new Expression('`cost` / (`length` * `width`)')])
                    ->where(['object_type_id' => $key])
                    ->andWhere(['NOT IN', 'id', array_keys($objectIdsCopy)]);

                if ($addGenType == TerritoryFacade::OPTIONS_BUDGET_ECONOMY) {
                    $objects = $objects->orderBy(['unit_cost' => SORT_ASC]);
                }

                $objects = $objects->all();

                array_pop($objectIdsCopy);
            }
            if (!$this->territory->fullnessIntervals[$objectTypeText]->belongToLastInterval($fillType)) {
                foreach ($objects as $object) {
                    $point = $this->findInstallPoint($object, $templateId);
                    if ($point) {
                        $installFlag = true;
                        $this->installObject($object, $point[0], $point[1], $point[2]);

                        if ($addGenType == 1 && $this->checkReferences($referenceUnitCost, $referenceEmptyCells)) {
                            $this->removeObject($object, $point[0], $point[1], $point[2]);
                            return false;
                        }

                        break;
                    }
                }
            }
            if ($installFlag) {
                break;
            }
        }

        // если не получилось подобрать объект
        return $installFlag;
    }

    public function checkReferences($referenceUnitCost, $referenceEmptyCells)
    {
        return $this->territory->calculateEmptyCells() <= $referenceEmptyCells || $this->territory->calculateUnitCost() > $referenceUnitCost;
    }

    // передаем тип очередного объекта и проверяем, есть ли возможность разместить хоть 1 такой объект
    public function isFilled()
    {
        $objects = ObjectWork::find()->all();
        $allowedFlag = true;
        foreach ($objects as $object) {
            $object->convertDimensionsToCells();
            if ($this->findInstallPoint($object)) {
                $allowedFlag = false;
            }
        }

        return $allowedFlag;
    }

    // ищем первую подходящую точку для установки объекта

    /**
     * @param ObjectWork $object
     * @param int|null $templateId ID шаблона расстановки, по которому произвести генерацию
     * @return array|false|int[]|mixed формат [left, top, position]
     */
    private function findInstallPoint(ObjectWork $object, int $templateId = null)
    {
        $object->convertDimensionsToCells();
        $square = $object->getSquareCells();
        switch ($object->object_type_id) {
            case ObjectWork::TYPE_RECREATION:
                if ($this->territory->state->fillRecreation + $square > $this->territory->state->recreationPart) {
                    return false;
                }
                break;
            case ObjectWork::TYPE_SPORT:
                if ($this->territory->state->fillSport + $square > $this->territory->state->sportPart) {
                    return false;
                }
                break;
            case ObjectWork::TYPE_EDUCATION:
                if ($this->territory->state->fillEducation + $square > $this->territory->state->educationPart) {
                    return false;
                }
                break;
            case ObjectWork::TYPE_GAME:
                if ($this->territory->state->fillGame + $square > $this->territory->state->gamePart) {
                    return false;
                }
                break;
            default:
                throw new Exception('Неизвестный тип объекта!');
        }

        $allowedFlag = false;
        $point = [];
        for ($i = 0; $i < $this->territory->lengthCellCount; $i++) {
            for ($j = 0; $j < $this->territory->widthCellCount; $j++) {
                if ($this->allowedInstall($object, $i, $j, TerritoryConcept::HORIZONTAL_POSITION, $templateId)) {
                    $point = count($point) == 0 ? [$i, $j, TerritoryConcept::HORIZONTAL_POSITION] : $point;
                    $allowedFlag = true;
                }
                if ($this->allowedInstall($object, $i, $j, TerritoryConcept::VERTICAL_POSITION, $templateId)) {
                    $point = count($point) == 0 ? [$i, $j, TerritoryConcept::VERTICAL_POSITION] : $point;
                    $allowedFlag = true;
                }
            }
        }

        return $allowedFlag ? $point : false;
    }


    public function correctWeightsByNeighbors($territoryId, &$weights)
    {
        $delim = 4;

        $neighbors = NeighboringTerritoryWork::find()->where(['neighboring_territory_id' => $territoryId])->all();
        if (count($neighbors) != 0) {
            foreach ($neighbors as $neighbor) {
                /** @var NeighboringTerritoryWork $neighbor */
                switch ($neighbor->territory->priority_type) {
                    case ObjectWork::TYPE_RECREATION:
                        $weights->recreation_weight = $weights->recreation_weight - $neighbor->territory->priority_coef / $delim;
                        break;
                    case ObjectWork::TYPE_SPORT:
                        $weights->sport_weight = $weights->sport_weight - $neighbor->territory->priority_coef / $delim;
                        break;
                    case ObjectWork::TYPE_EDUCATION:
                        $weights->education_weight = $weights->education_weight - $neighbor->territory->priority_coef / $delim;
                        break;
                    case ObjectWork::TYPE_GAME:
                        $weights->game_weight = $weights->game_weight - $neighbor->territory->priority_coef / $delim;
                        break;
                }
            }
        }
    }

    /**
     * @param ArrangementModelFacade $model модель данных о территории
     * @param string $generateType тип генерации @see TerritoryConcept
     * @param int $territoryId id территории
     * @return void
     */
    public static function saveArrangement(ArrangementModelFacade $model, $generateType, $territoryId)
    {
        $entity = new ArrangementWork();
        $entity->model = serialize($model);
        $entity->user_id = UserWork::getAuthUser()->id;
        $entity->datetime = date('Y.m.d H:i:s');
        $entity->generate_type = $generateType;
        $entity->territory_id = $territoryId;
        $entity->save();
    }

    public function correctArrangement(int $fullness, $params = [])
    {
        $exceptedFullness = TerritoryConcept::getExceptedFullness($fullness); // ожидаемый уровень заполненности (интервал в долях от 1)
        $currentFullness = $this->territory->calculateCurrentFullness(); // текущий уровень заполненности (в долях от 1)

        // выберем случайное число из интервала, меньше которого нельзя опускаться
        $borderPercent = random_int($exceptedFullness[0] * 100, $exceptedFullness[1] * 100) / 100;

        if (isset($params['originalFullness'])) {
            $borderPercent = $params['originalFullness'];
        }

        // удаляем объекты пока заполненность не снизится
        while ($currentFullness > $borderPercent) {
            $this->deleteRedundantObject();
            $currentFullness = $this->territory->calculateCurrentFullness();
        }
    }

    private function deleteRedundantObject()
    {
        $objIds = $this->territory->state->objectIds;
        arsort($objIds);
        $delId = array_keys($objIds)[0];
        $left = 0;
        $top = 0;
        $position = TerritoryConcept::HORIZONTAL_POSITION;

        foreach ($this->territory->state->objectsList as $objectExt) {
            if ($objectExt->object->id == $delId) {
                $left = $objectExt->left;
                $top = $objectExt->top;
                $position = $objectExt->positionType;
                break;
            }
        }

        $this->removeObject(ObjectWork::findOne(['id' => $delId]), $left, $top, $position);
    }
}