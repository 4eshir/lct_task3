<?php

namespace app\models\forms\sandbox;

use yii\base\Model;

class LoadObjectForm extends Model
{
    public $name;
    public $width;
    public $length;
    public $height;
    public $cost;
    public $object_type_id;
    public $creator;
    public $article;

    public $left_age;
    public $right_age;
    public $created_time;
    public $install_time;
    public $worker_count;
    public $dead_zone_size;
    public $style;

    public function rules()
    {
        return [
            [['name', 'width', 'length', 'height', 'cost', 'object_type_id', 'creator', 'article'], 'required'],
            [['name', 'creator', 'article', 'style'], 'string'],
            [['width', 'length', 'height', 'cost', 'object_type_id', 'left_age', 'right_age', 'created_time', 'install_time', 'worker_count', 'dead_zone_size'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'name',
            'width' => 'width',
            'length' => 'length',
            'height' => 'height',
            'cost' => 'cost',
            'object_type_id' => 'object_type_id',
            'creator' => 'creator',
            'article' => 'article',
            'left_age' => 'left_age',
            'right_age' => 'right_age',
            'created_time' => 'created_time',
            'install_time' => 'install_time',
            'worker_count' => 'worker_count',
            'dead_zone_size' => 'dead_zone_size',
            'style' => 'style',
        ];
    }
}