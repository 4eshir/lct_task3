<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "playground".
 *
 * @property int $id
 * @property int|null $playground_type_id
 *
 * @property PlaygroundType $playgroundType
 */
class Playground extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'playground';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['playground_type_id'], 'integer'],
            [['playground_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PlaygroundType::class, 'targetAttribute' => ['playground_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'playground_type_id' => 'Playground Type ID',
        ];
    }

    /**
     * Gets query for [[PlaygroundType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlaygroundType()
    {
        return $this->hasOne(PlaygroundType::class, ['id' => 'playground_type_id']);
    }
}
