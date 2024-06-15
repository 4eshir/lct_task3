<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "template_block".
 *
 * @property int $id
 * @property int|null $top
 * @property int|null $left
 * @property int|null $width Процент от общей высоты площадки
 * @property int|null $length Процент от общей длины площадки
 * @property int|null $object_type_id ID из таблицы object_type, если null - то строить нельзя
 * @property int|null $arrangement_template_id
 *
 * @property ArrangementTemplate $arrangementTemplate
 * @property ObjectType $objectType
 */
class TemplateBlock extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'template_block';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['top', 'left', 'width', 'length', 'object_type_id', 'arrangement_template_id'], 'integer'],
            [['object_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ObjectType::class, 'targetAttribute' => ['object_type_id' => 'id']],
            [['arrangement_template_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArrangementTemplate::class, 'targetAttribute' => ['arrangement_template_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'top' => 'Top',
            'left' => 'Left',
            'width' => 'Width',
            'length' => 'Length',
            'object_type_id' => 'Object Type ID',
            'arrangement_template_id' => 'Arrangement Template ID',
        ];
    }

    /**
     * Gets query for [[ArrangementTemplate]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArrangementTemplate()
    {
        return $this->hasOne(ArrangementTemplate::class, ['id' => 'arrangement_template_id']);
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
}
