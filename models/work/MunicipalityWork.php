<?php

namespace app\models\work;

use app\models\common\Municipality;
use yii\helpers\ArrayHelper;

class MunicipalityWork extends Municipality
{
    public static function GetAllMunicipalities()
    {
        $data = MunicipalityWork::find()->all();

        $result = ArrayHelper::map($data, 'id', 'name');

        return $result;
    }
}