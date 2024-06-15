<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "playground_type".
 *
 * @property int $id
 * @property float|null $sport_coef
 * @property float|null $game_coef
 * @property float|null $education_coef
 * @property float|null $recreation_coef
 * @property int|null $priority_ages_id
 *
 * @property Playground[] $playgrounds
 * @property Ages $priorityAges
 */
class PlaygroundType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'playground_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sport_coef', 'game_coef', 'education_coef', 'recreation_coef'], 'number'],
            [['priority_ages_id'], 'integer'],
            [['priority_ages_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ages::class, 'targetAttribute' => ['priority_ages_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sport_coef' => 'Sport Coef',
            'game_coef' => 'Game Coef',
            'education_coef' => 'Education Coef',
            'recreation_coef' => 'Recreation Coef',
            'priority_ages_id' => 'Priority Ages ID',
        ];
    }

    /**
     * Gets query for [[Playgrounds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaygrounds()
    {
        return $this->hasMany(Playground::class, ['playground_type_id' => 'id']);
    }

    /**
     * Gets query for [[PriorityAges]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPriorityAges()
    {
        return $this->hasOne(Ages::class, ['id' => 'priority_ages_id']);
    }
}
