<?php

namespace app\models\forms\sandbox;

use yii\base\Model;

class GetRealWeightsForm extends Model
{
    public $tId;
    public $agesInterval;
    public $weightsType;

    public function rules()
    {
        return [
            ['tId', 'required'],
            [['tId', 'agesInterval'], 'integer'],
            [['weightsType'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tId' => 'tId',
            'agesInterval' => 'agesInterval',
            'weightsType' => 'weightsType',
        ];
    }
}