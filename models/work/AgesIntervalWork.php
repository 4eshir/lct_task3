<?php

namespace app\models\work;

use app\models\common\AgesInterval;
use yii\helpers\ArrayHelper;

class AgesIntervalWork extends AgesInterval
{
    public static function GetAllIntervals()
    {
        $data = AgesInterval::find()->all();

        $result = ArrayHelper::map($data, 'id', function($model) {
            return $model['left_age'] . ' - ' . $model['right_age'].' л.';
        });

        return $result;
    }
}