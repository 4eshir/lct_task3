<?php

namespace app\models\forms;

use yii\base\Model;

class ChooseTerritoryForm extends Model
{
    public $territoryId;

    public function rules()
    {
        return [
            [['territoryId'], 'required'],
            [['territoryId'], 'integer'],
        ];
    }

    public function save()
    {

    }
}