<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "ages_weight".
 *
 * @property int $id
 * @property int|null $left_age
 * @property int|null $right_age
 * @property float|null $self_weight
 * @property float|null $sport_weight
 * @property float|null $game_weight
 * @property float|null $education_weight
 * @property float|null $recreation_weight
 */
class AgesWeight extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ages_weight';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['left_age', 'right_age'], 'integer'],
            [['self_weight', 'sport_weight', 'game_weight', 'education_weight', 'recreation_weight'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'left_age' => 'Left Age',
            'right_age' => 'Right Age',
            'self_weight' => 'Self Weight',
            'sport_weight' => 'Sport Weight',
            'game_weight' => 'Game Weight',
            'education_weight' => 'Education Weight',
            'recreation_weight' => 'Recreation Weight',
        ];
    }
}
