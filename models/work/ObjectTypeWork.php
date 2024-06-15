<?php

namespace app\models\work;

use app\models\common\ObjectType;
use yii\helpers\ArrayHelper;

class ObjectTypeWork extends ObjectType
{

    public static function GetAllTypes()
    {
        $data = ObjectTypeWork::find()->all();

        $result = ArrayHelper::map($data, 'id', 'name');

        return $result;
    }
}