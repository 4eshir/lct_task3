<?php


namespace app\facades;


use app\components\arrangement\TerritoryConcept;
use app\components\coordinates\LocalCoordinatesManager;
use app\models\ObjectExtended;
use app\models\work\ObjectWork;
use app\models\work\TerritoryWork;

class ArrangementModelFacade
{
    private $matrix; // матрица расстановки объектов
    private $objects; // список объектов формата [id => кол-во, ...]
    public $objectsPosition; /** список объектов @see ObjectExtended */

    public function __construct(array $matrix, array $objects, array $objectsList)
    {
        $this->matrix = $matrix;
        $this->objects = $objects;
        $this->objectsPosition = $objectsList;
    }

    public function getRawMatrix()
    {
        return $this->matrix;
    }

    public function getObjectsCount()
    {
        return $this->objects;
    }

    public function getObjectsList()
    {
        return $this->objectsPosition;
    }

    public function showMatrix($stream)
    {
        for ($i = 0; $i < count($this->matrix); $i++) {
            for ($j = 0; $j < count($this->matrix[$i]); $j++) {
                fwrite($stream, $this->matrix[$i][$j].' ');
            }
            fwrite($stream, "\n");
        }

        fwrite($stream, "\n");
    }

    public function setMatrix(array $matrix)
    {
        $this->matrix = $matrix;
    }

    public function setObjectsCount(array $objects)
    {
        $this->objects = $objects;
    }

    public function setObjectsList(array $objectsList)
    {
        $this->objectsPosition = $objectsList;
    }

    public function calculateBudget()
    {
        $sum = 0;
        foreach ($this->objectsPosition as $object) {
            /** @var ObjectExtended $object */
            $sum += $object->object->cost;
        }

        return $sum;
    }

    public function calculateCreatedTime()
    {
        $sum = 0;
        foreach ($this->objectsPosition as $object) {
            /** @var ObjectExtended $object */
            $sum += $object->object->created_time;
        }

        return $sum;
    }

    public function calculateInstallationTime()
    {
        $sum = 0;
        foreach ($this->objectsPosition as $object) {
            /** @var ObjectExtended $object */
            $sum += $object->object->install_time;
        }

        return $sum;
    }

    public function getDataForScene($tId)
    {
        $matrix = $this->getRawMatrix();
        $objectsList = $this->objectsPosition;
        $resultObjList = [];
        $maxHeight = 0;

        $territory = TerritoryWork::find()->where(['id' => $tId])->one();

        foreach ($objectsList as $objectExt) {
            /** @var ObjectExtended $objectExt */
            if ($maxHeight < $objectExt->object->height) {
                $maxHeight = $objectExt->object->height;
            }

            $resultObjList[] = [
                'id' => $objectExt->object->id,
                'name' => $objectExt->object->name,
                'height' => ObjectWork::convertDistanceToCells($objectExt->object->height, TerritoryConcept::STEP),
                'width' => ObjectWork::convertDistanceToCells($objectExt->object->width, TerritoryConcept::STEP),
                'length' => ObjectWork::convertDistanceToCells($objectExt->object->length, TerritoryConcept::STEP),
                'cost' => $objectExt->object->cost,
                'rotate' => $objectExt->positionType == TerritoryConcept::HORIZONTAL_POSITION ? TerritoryConcept::HORIZONTAL_POSITION : 90,
                'link' => $objectExt->object->model_path,
                'dotCenter' => [
                    'x' => LocalCoordinatesManager::calculateLocalCoordinates($territory, $objectExt)['x'],
                    'y' => LocalCoordinatesManager::calculateLocalCoordinates($territory, $objectExt)['y'],
                ],
            ];
        }

        return json_encode(
            [
                'result' => [
                    'matrixCount' => [
                        'width' => count($matrix[0]),
                        'height' => count($matrix),
                        'maxHeight' => ObjectWork::convertDistanceToCells($maxHeight, TerritoryConcept::STEP),
                    ],
                    'matrix' => $matrix,
                    'objects' => $resultObjList,
                ],
                'analytic' => [
                    'data' => $this->getAnalyticData(),
                ],
            ],
        );
    }

    public function getAnalyticData()
    {
        return
            [
                'summary' => $this->getSumCost(),
                'workers_count' => $this->getWorkersCount(),
                'install_time_parallel' => $this->getInstallTime(),
                'install_time_sequence' => $this->getInstallTime(false),
                'created_time_parallel' => $this->getCreatedTime(),
                'created_time_sequence' => $this->getCreatedTime(false),
                'creators_list' => $this->getCreatorsList(),
                'style' => $this->getStylesList(),
            ];
    }

    public function getSumCost()
    {
        $sum = 0;
        foreach ($this->objectsPosition as $objectExt) {
            /** @var ObjectExtended $objectExt */
            $sum += $objectExt->object->cost;
        }

        return $sum;
    }

    public function getWorkersCount()
    {
        $sum = 0;
        foreach ($this->objectsPosition as $objectExt) {
            /** @var ObjectExtended $objectExt */
            $sum += $objectExt->object->worker_count;
        }

        return $sum;
    }

    /**
     * @param bool $parallel разрешена ли параллельная установка
     * @return float|int|null
     */
    public function getInstallTime($parallel = true)
    {
        if ($parallel) {
            $max = 0;
            foreach ($this->objectsPosition as $objectExt) {
                /** @var ObjectExtended $objectExt */
                if ($objectExt->object->install_time > $max) {
                    $max = $objectExt->object->install_time;
                }
            }

            return $max;
        }
        else {
            $sum = 0;
            foreach ($this->objectsPosition as $objectExt) {
                /** @var ObjectExtended $objectExt */
                $sum += $objectExt->object->install_time;
            }

            return $sum;
        }
    }

    /**
     * @param bool $parallel разрешено ли параллельное создание
     * @return int|null
     */
    public function getCreatedTime($parallel = true)
    {
        if ($parallel) {
            $max = 0;
            foreach ($this->objectsPosition as $objectExt) {
                /** @var ObjectExtended $objectExt */
                if ($objectExt->object->created_time > $max) {
                    $max = $objectExt->object->created_time;
                }
            }

            return $max;
        }
        else {
            $sum = 0;
            foreach ($this->objectsPosition as $objectExt) {
                /** @var ObjectExtended $objectExt */
                $sum += $objectExt->object->created_time;
            }

            return $sum;
        }
    }

    public function getCreatorsList()
    {
        $creators = [];
        foreach ($this->objectsPosition as $objectExt) {
            /** @var ObjectExtended $objectExt */
            if (!in_array($objectExt->object->creator, $creators)) {
                $creators[] = $objectExt->object->creator;
            }
        }

        return $creators;
    }

    public function getStylesList()
    {
        $styles = [];
        foreach ($this->objectsPosition as $objectExt) {
            /** @var ObjectExtended $objectExt */
            if (!in_array($objectExt->object->style, $styles)) {
                $styles[] = $objectExt->object->style;
            }
        }

        return $styles;
    }
}