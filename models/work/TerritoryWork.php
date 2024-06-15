<?php

namespace app\models\work;

use app\models\common\Territory;
use yii\helpers\ArrayHelper;

class TerritoryWork extends Territory
{
        public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'length' => 'Длина (в см)',
            'width' => 'Ширина (в см)',
            'name' => 'Название',
            'address' => 'Адрес',
            'geo_coord' => 'Координаты (wgs84)',
        ];
    }

    public static function GetAllTerritories()
    {
        $data = TerritoryWork::find()->all();

        $result = ArrayHelper::map($data, 'id', 'name');

        return $result;
    }

    public static function getFixedTerritories()
    {
        $tIds = PeopleTerritoryWork::find()->where(['count' => 1])->all();
        $territories = TerritoryWork::find()->where(['IN', 'id', ArrayHelper::getColumn($tIds, 'territory_id')])->all();

        return ArrayHelper::map($territories, 'id', 'name');
    }

    public function getPrettyPriorityType()
    {
        switch ($this->priority_type) {
            case ObjectWork::TYPE_RECREATION:
                return 'Рекреационная';
            case ObjectWork::TYPE_SPORT:
                return 'Спортивная';
            case ObjectWork::TYPE_EDUCATION:
                return 'Развивающая';
            case ObjectWork::TYPE_GAME:
                return 'Игровая';
            default:
                return 'Не определена';
        }
    }

    public function getPrettyPriorityCoef()
    {
        $style = 'color: green';
        if ($this->priority_coef < 0.8 && $this->priority_coef > 0.4) {
            $style = 'color: orange';
        }
        if ($this->priority_coef <= 0.4) {
            $style = 'color: red';
        }

        return '<span style="'.$style.'"><b>'.$this->priority_coef.'</b></span>';
    }

    public function getInfluence()
    {
        $data = '<span>Сильное</span>';
        if ($this->priority_coef < 0.8 && $this->priority_coef > 0.4) {
            $data = '<span>Среднее</span>';
        }
        if ($this->priority_coef <= 0.4) {
            $data = '<span>Слабое</span>';
        }

        return $data;
    }
}