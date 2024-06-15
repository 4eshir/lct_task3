<?php

namespace app\models\work;

use app\models\common\AgesWeight;

class AgesWeightWork extends AgesWeight
{
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'left_age' => 'Возраст (от)',
            'right_age' => 'Возраст (до)',
            'self_weight' => 'Вес возрастной категории',
            'sport_weight' => 'Вес спортивных объектов',
            'game_weight' => 'Вес игровых объектов',
            'education_weight' => 'Вес образовательных объектов',
            'recreation_weight' => 'Вес рекреационных объектов',
            'ages_interval_id' => 'Возрастной интервал',
        ];
    }
}