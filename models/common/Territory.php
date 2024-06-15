<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "territory".
 *
 * @property int $id
 * @property int|null $length
 * @property int|null $width
 * @property string|null $name
 * @property string|null $address
 * @property float|null $latitude Широта
 * @property float|null $longitude Долгота
 * @property int|null $priority_type 1 - рекреация, 2 - спорт, 3 - развивающая, 4 - игровая
 * @property float|null $priority_coef
 *
 * @property AgesWeightChangeable[] $agesWeightChangeables
 * @property Arrangement[] $arrangements
 * @property Municipality[] $municipalities
 * @property NeighboringTerritory[] $neighboringTerritories
 * @property NeighboringTerritory[] $neighboringTerritories0
 * @property PeopleTerritory[] $peopleTerritories
 * @property Questionnaire[] $questionnaires
 * @property RestrictObjectTerritory[] $restrictObjectTerritories
 */
class Territory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'territory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['length', 'width', 'priority_type'], 'integer'],
            [['latitude', 'longitude', 'priority_coef'], 'number'],
            [['name'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'length' => 'Length',
            'width' => 'Width',
            'name' => 'Name',
            'address' => 'Address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'priority_type' => 'Priority Type',
            'priority_coef' => 'Priority Coef',
        ];
    }

    /**
     * Gets query for [[AgesWeightChangeables]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgesWeightChangeables()
    {
        return $this->hasMany(AgesWeightChangeable::class, ['territory_id' => 'id']);
    }

    /**
     * Gets query for [[Arrangements]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArrangements()
    {
        return $this->hasMany(Arrangement::class, ['territory_id' => 'id']);
    }

    /**
     * Gets query for [[Municipalities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipalities()
    {
        return $this->hasMany(Municipality::class, ['territory_id' => 'id']);
    }

    /**
     * Gets query for [[NeighboringTerritories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNeighboringTerritories()
    {
        return $this->hasMany(NeighboringTerritory::class, ['territory_id' => 'id']);
    }

    /**
     * Gets query for [[NeighboringTerritories0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNeighboringTerritories0()
    {
        return $this->hasMany(NeighboringTerritory::class, ['neighboring_territory_id' => 'id']);
    }

    /**
     * Gets query for [[PeopleTerritories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPeopleTerritories()
    {
        return $this->hasMany(PeopleTerritory::class, ['territory_id' => 'id']);
    }

    /**
     * Gets query for [[Questionnaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaires()
    {
        return $this->hasMany(Questionnaire::class, ['territory_id' => 'id']);
    }

    /**
     * Gets query for [[RestrictObjectTerritories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestrictObjectTerritories()
    {
        return $this->hasMany(RestrictObjectTerritory::class, ['territory_id' => 'id']);
    }
}
