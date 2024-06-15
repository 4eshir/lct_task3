<?php

namespace app\models\forms\sandbox;

use yii\base\Model;

class LoadTerritoryForm extends Model
{
    public $name;
    public $width;
    public $length;
    public $address;
    public $latitude;
    public $longitude;

    public function rules()
    {
        return [
            [['name', 'width', 'length', 'address', 'latitude', 'longitude'], 'required'],
            [['name'], 'string'],
            [['width', 'length'], 'integer'],
            [['latitude', 'longitude'], 'double'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'name',
            'width' => 'width',
            'length' => 'length',
            'address' => 'address',
            'latitude' => 'latitude',
            'longitude' => 'longitude',
        ];
    }
}