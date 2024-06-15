<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "municipality".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sport_tendency
 * @property int|null $game_tendency
 * @property int|null $education_tendency
 * @property int|null $recreation_tendency
 * @property int|null $territory_id
 *
 * @property Ages[] $ages
 * @property Territory $territory
 * @property User[] $users
 */
class Municipality extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'municipality';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sport_tendency', 'game_tendency', 'education_tendency', 'recreation_tendency', 'territory_id'], 'integer'],
            [['name'], 'string', 'max' => 128],
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
            'name' => 'Name',
            'sport_tendency' => 'Sport Tendency',
            'game_tendency' => 'Game Tendency',
            'education_tendency' => 'Education Tendency',
            'recreation_tendency' => 'Recreation Tendency',
            'territory_id' => 'Territory ID',
        ];
    }

    /**
     * Gets query for [[Ages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAges()
    {
        return $this->hasMany(Ages::class, ['municipality_id' => 'id']);
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

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['municipality_id' => 'id']);
    }
}
