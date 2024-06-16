<?php

namespace app\models\forms\demo;

use app\components\arrangement\TerritoryConcept;
use app\facades\TerritoryFacade;
use yii\base\Model;

class GenerateByParamsForm extends Model
{
    public $recreation = 0;
    public $sport = 0;
    public $education = 0;
    public $game = 0;

    public $addGenerateType = TerritoryFacade::OPTIONS_DEFAULT;
    public $fullness = TerritoryFacade::OPTIONS_DEFAULT;

    public function rules()
    {
        return [
            [['recreation', 'sport', 'education', 'game'], 'double'],
            [['addGenerateType', 'fullness'], 'integer'],
            [['recreation', 'sport', 'education', 'game', 'addGenerateType', 'fullness'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'recreation' => 'Приоритет рекреационных МАФ',
            'sport' => 'Приоритет спортивных МАФ',
            'education' => 'Приоритет развивающих МАФ',
            'game' => 'Приоритет игровых МАФ',
            'addGenerateType' => 'Тип генерации',
            'fullness' => 'Уровень наполненности',
        ];
    }
}