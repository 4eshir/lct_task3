<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "ages_weight_changeable".
 *
 * @property int $id
 * @property float|null $self_weight
 * @property float|null $sport_weight
 * @property float|null $game_weight
 * @property float|null $education_weight
 * @property float|null $recreation_weight
 * @property int|null $ages_interval_id
 * @property int|null $territory_id
 *
 * @property AgesInterval $agesInterval
 * @property Territory $territory
 */
class AgesWeightChangeable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ages_weight_changeable';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['self_weight', 'sport_weight', 'game_weight', 'education_weight', 'recreation_weight'], 'number'],
            [['ages_interval_id', 'territory_id'], 'integer'],
            [['ages_interval_id'], 'exist', 'skipOnError' => true, 'targetClass' => AgesInterval::class, 'targetAttribute' => ['ages_interval_id' => 'id']],
            [['territory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Territory::class, 'targetAttribute' => ['territory_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'self_weight' => 'Self Weight',
            'sport_weight' => 'Sport Weight',
            'game_weight' => 'Game Weight',
            'education_weight' => 'Education Weight',
            'recreation_weight' => 'Recreation Weight',
            'ages_interval_id' => 'Ages Interval ID',
            'territory_id' => 'Territory ID',
        ];
    }

    /**
     * Gets query for [[AgesInterval]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgesInterval()
    {
        return $this->hasOne(AgesInterval::class, ['id' => 'ages_interval_id']);
    }

    /**
     * Gets query for [[Territory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTerritory()
    {
        return $this->hasOne(Territory::class, ['id' => 'territory_id']);
    }
}
