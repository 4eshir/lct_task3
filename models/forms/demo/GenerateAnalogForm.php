<?php


namespace app\models\forms\demo;


use app\components\arrangement\TerritoryConcept;
use app\facades\TerritoryFacade;
use yii\base\Model;

class GenerateAnalogForm extends Model
{
    public $analogTerritoryId;
    public $fullness = TerritoryConcept::TYPE_FULLNESS_ORIGINAL;

    public function rules()
    {
        return [
            [['analogTerritoryId', 'fullness'], 'integer'],
            [['analogTerritoryId', 'fullness'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'analogTerritoryId' => 'Выберите территорию',
            'fullness' => 'Выберите степень наполненности',
        ];
    }
}