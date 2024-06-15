<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "arrangement".
 *
 * @property int $id
 * @property string|null $model
 * @property int|null $user_id
 * @property string|null $generate_type base - на базовых весах, change - на измененных весах, self - на основе голосов пользователя, manual - собрано вручную
 * @property string|null $datetime
 * @property int|null $territory_id
 *
 * @property Territory $territory
 * @property User $user
 */
class Arrangement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arrangement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model'], 'string'],
            [['user_id', 'territory_id'], 'integer'],
            [['datetime'], 'safe'],
            [['generate_type'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'model' => 'Model',
            'user_id' => 'User ID',
            'generate_type' => 'Generate Type',
            'datetime' => 'Datetime',
            'territory_id' => 'Territory ID',
        ];
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
