<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "object_type".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Object[] $objects
 * @property RestrictObjectTerritory[] $restrictObjectTerritories
 */
class ObjectType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 128],
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
        ];
    }

    /**
     * Gets query for [[Objects]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getObjects()
    {
        return $this->hasMany(Object::class, ['object_type_id' => 'id']);
    }

    /**
     * Gets query for [[RestrictObjectTerritories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRestrictObjectTerritories()
    {
        return $this->hasMany(RestrictObjectTerritory::class, ['object_type_id' => 'id']);
    }
}
