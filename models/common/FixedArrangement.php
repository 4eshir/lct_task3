<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "fixed_arrangement".
 *
 * @property int $id
 * @property int|null $territory_id
 * @property int|null $object_id
 * @property int|null $left
 * @property int|null $top
 * @property int|null $position 0 - горизонтальное, 1 - вертикальное
 *
 * @property Object $object
 * @property Territory $territory
 */
class FixedArrangement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fixed_arrangement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['territory_id', 'object_id', 'left', 'top', 'position'], 'integer'],
            [['territory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Territory::class, 'targetAttribute' => ['territory_id' => 'id']],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectT::class, 'targetAttribute' => ['object_id' => 'id']],
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
            'object_id' => 'Object ID',
            'left' => 'Left',
            'top' => 'Top',
            'position' => 'Position',
        ];
    }

    /**
     * Gets query for [[Object]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(ObjectT::class, ['id' => 'object_id']);
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
