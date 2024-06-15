<?php

namespace app\models\forms\sandbox;

use yii\base\Model;

class GenerateArrangementForm extends Model
{
    public $tId;
    public $genType;
    public $addGenType;
    public $params;

    public function rules()
    {
        return [
            [['tId', 'genType'], 'required'],
            [['genType', 'params'], 'string'],
            [['addGenType', 'tId'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tId' => 'tId',
            'genType' => 'genType',
            'addGenType' => 'addGenType',
            'params' => 'params',
        ];
    }
}