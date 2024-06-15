<?php

namespace app\models\forms\sandbox;

use yii\base\Model;

class GetObjectsForm extends Model
{
    public $type;
    public $minCost;
    public $maxCost;
    public $style;

    public $result;

    public function rules()
    {
        return [
            [['type', 'minCost', 'maxCost'], 'integer'],
            [['style'], 'string'],
            [['result'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'type' => 'type',
            'minCost' => 'minCost',
            'maxCost' => 'maxCost',
            'style' => 'style',
        ];
    }
}