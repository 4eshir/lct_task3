<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "ages".
 *
 * @property int $id
 * @property int|null $left_age
 * @property int|null $right_age
 * @property int|null $count
 * @property int|null $municipality_id
 *
 * @property Municipality $municipality
 * @property PlaygroundType[] $playgroundTypes
 */
class Ages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['left_age', 'right_age', 'count', 'municipality_id'], 'integer'],
            [['municipality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Municipality::class, 'targetAttribute' => ['municipality_id' => 'id']],
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
            'count' => 'Count',
            'municipality_id' => 'Municipality ID',
        ];
    }

    /**
     * Gets query for [[Municipality]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'municipality_id']);
    }

    /**
     * Gets query for [[PlaygroundTypes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaygroundTypes()
    {
        return $this->hasMany(PlaygroundType::class, ['priority_ages_id' => 'id']);
    }
}
