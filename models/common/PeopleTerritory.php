<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "people_territory".
 *
 * @property int $id
 * @property int|null $count
 * @property int|null $ages_interval_id
 * @property int|null $territory_id
 *
 * @property AgesInterval $agesInterval
 * @property Territory $territory
 */
class PeopleTerritory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'people_territory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count', 'ages_interval_id', 'territory_id'], 'integer'],
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
            'count' => 'Count',
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
