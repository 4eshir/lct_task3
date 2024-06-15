<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "neighboring_territory".
 *
 * @property int $id
 * @property int|null $territory_id
 * @property int|null $neighboring_territory_id
 *
 * @property Territory $neighboringTerritory
 * @property Territory $territory
 */
class NeighboringTerritory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'neighboring_territory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['territory_id', 'neighboring_territory_id'], 'integer'],
            [['territory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Territory::class, 'targetAttribute' => ['territory_id' => 'id']],
            [['neighboring_territory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Territory::class, 'targetAttribute' => ['neighboring_territory_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'territory_id' => 'Territory ID',
            'neighboring_territory_id' => 'Neighboring Territory ID',
        ];
    }

    /**
     * Gets query for [[NeighboringTerritory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNeighboringTerritory()
    {
        return $this->hasOne(Territory::class, ['id' => 'neighboring_territory_id']);
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
