<?php

namespace app\models\common;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string|null $login
 * @property int|null $municipality_id
 * @property int|null $role 1 - житель, 2 - член администрации, 3 - бог
 * @property int|null $auth_flag
 *
 * @property Municipality $municipality
 * @property Questionnaire[] $questionnaires
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['municipality_id', 'role', 'auth_flag'], 'integer'],
            [['login'], 'string', 'max' => 255],
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
            'login' => 'Login',
            'municipality_id' => 'Municipality ID',
            'role' => 'Role',
            'auth_flag' => 'Auth Flag',
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
     * Gets query for [[Questionnaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaires()
    {
        return $this->hasMany(Questionnaire::class, ['user_id' => 'id']);
    }
}
