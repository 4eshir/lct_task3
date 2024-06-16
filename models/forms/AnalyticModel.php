<?php


namespace app\models\forms;


use app\components\coordinates\LocalCoordinatesManager;
use app\facades\ArrangementModelFacade;
use app\models\ObjectExtended;
use app\models\work\TerritoryWork;

class AnalyticModel
{
    public $summaryCost;
    public $createdTimeSequence;
    public $createdTimeParallel;
    public $installTimeSequence;
    public $installTimeParallel;
    public $workersCount;
    public $creators;
    public $style;

    public $addData;

    public $uploadFlag = true;

    public function fill(ArrangementModelFacade $model)
    {
        $this->summaryCost = $model->calculateBudget();
        $this->createdTimeSequence = $model->getCreatedTime(false);
        $this->createdTimeParallel = $model->getCreatedTime(true);
        $this->installTimeSequence = $model->getInstallTime(false);
        $this->installTimeParallel = $model->getInstallTime(true);
        $this->workersCount = $model->getWorkersCount();
        $this->creators = $model->getCreatorsList();
        $this->style = $model->getStylesList();
    }

    public function getPrettyStyle()
    {
        if (count($this->style) > 1) {
            return 'Смешанный (' . implode(', ', $this->style) . ')';
        }

        return $this->style[0];
    }

    public function getPrettyCreators()
    {
        return implode(', ', $this->creators);
    }

    public function fillAdd(ArrangementModelFacade $model, TerritoryWork $territory)
    {
        $result = [];
        foreach ($model->objectsPosition as $objectExt) {
            /** @var ObjectExtended $objectExt */
            $wgs = LocalCoordinatesManager::convertLocalToWGS84(['x' => $objectExt->left, 'y' => $objectExt->top], ['latitude' => $territory->latitude, 'longitude' => $territory->longitude]);
            $result[] = [
                'name' => $objectExt->object->name,
                'type' => $objectExt->object->objectType->name,
                'coord_x' => $wgs['latitude'],
                'coord_y' => $wgs['longitude'],
            ];
        }
        $this->addData = $result;
    }
}