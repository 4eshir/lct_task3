<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "restrict_object_territory".
 *
 * @property int $id
 * @property int|null $object_type_id
 * @property int|null $territory_id
 *
 * @property ObjectType $objectType
 * @property Territory $territory
 */
class RestrictObjectTerritory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'restrict_object_territory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['object_type_id', 'territory_id'], 'integer'],
            [['object_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectType::class, 'targetAttribute' => ['object_type_id' => 'id']],
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
            'object_type_id' => 'Object Type ID',
            'territory_id' => 'Territory ID',
        ];
    }

    /**
     * Gets query for [[ObjectType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjectType()
    {
        return $this->hasOne(ObjectType::class, ['id' => 'object_type_id']);
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
