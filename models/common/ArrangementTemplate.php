<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "arrangement_template".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 *
 * @property TemplateBlock[] $templateBlocks
 */
class ArrangementTemplate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arrangement_template';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'string', 'max' => 255],
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
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[TemplateBlocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTemplateBlocks()
    {
        return $this->hasMany(TemplateBlock::class, ['arrangement_template_id' => 'id']);
    }
}
