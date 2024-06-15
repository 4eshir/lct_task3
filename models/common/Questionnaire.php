<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "questionnaire".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $ages_interval_id
 * @property int|null $sport_tendency
 * @property int|null $recreation_tendency
 * @property int|null $game_tendency
 * @property int|null $education_tendency
 * @property string|null $arrangement_matrix
 * @property int|null $territory_id
 *
 * @property AgesInterval $agesInterval
 * @property Territory $territory
 * @property User $user
 */
class Questionnaire extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaire';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ages_interval_id', 'sport_tendency', 'recreation_tendency', 'game_tendency', 'education_tendency', 'territory_id'], 'integer'],
            [['arrangement_matrix'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'ages_interval_id' => 'Ages Interval ID',
            'sport_tendency' => 'Sport Tendency',
            'recreation_tendency' => 'Recreation Tendency',
            'game_tendency' => 'Game Tendency',
            'education_tendency' => 'Education Tendency',
            'arrangement_matrix' => 'Arrangement Matrix',
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
