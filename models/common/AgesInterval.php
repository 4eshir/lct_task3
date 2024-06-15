<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "ages_interval".
 *
 * @property int $id
 * @property int|null $left_age
 * @property int|null $right_age
 *
 * @property Ages[] $ages
 * @property AgesWeight[] $agesWeights
 * @property Questionnaire[] $questionnaires
 */
class AgesInterval extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ages_interval';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['left_age', 'right_age'], 'integer'],
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
        ];
    }

    /**
     * Gets query for [[Ages]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAges()
    {
        return $this->hasMany(Ages::class, ['ages_interval_id' => 'id']);
    }

    /**
     * Gets query for [[AgesWeights]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAgesWeights()
    {
        return $this->hasMany(AgesWeight::class, ['ages_interval_id' => 'id']);
    }

    /**
     * Gets query for [[Questionnaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaires()
    {
        return $this->hasMany(Questionnaire::class, ['ages_interval_id' => 'id']);
    }
}
