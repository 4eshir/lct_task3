<?php


namespace app\models\forms;


use app\facades\ArrangementModelFacade;

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
}