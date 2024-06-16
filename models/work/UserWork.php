<?php

namespace app\models\work;


use app\models\common\User;
use yii\db\Exception;
use yii\helpers\ArrayHelper;

class UserWork extends User
{
    const ROLE_CITIZEN = 1;
    const ROLE_ADMINISTRATOR = 2;
    const ROLE_GOD = 3;

    public static function GetAllRoles()
    {
        $data = [
            self::ROLE_CITIZEN => 'Житель',
            self::ROLE_ADMINISTRATOR => 'Администратор',
            self::ROLE_GOD => 'Админ системы',
        ];

        return $data;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'municipality_id' => 'Муниципалитет',
            'role' => 'Роль в системе',
            'auth_flag' => 'Auth Flag',
        ];
    }

    /**
     * Возвращает аутентифицированного пользователя
     * @return array|\yii\db\ActiveRecord|null
     */
    public static function getAuthUser()
    {
        return UserWork::find()->where(['auth_flag' => 1])->one();
    }

    public static function logout()
    {
        $entity = self::getAuthUser();
        if ($entity) {
            $entity->auth_flag = 0;
            $entity->save();
        }
    }


    public function getPrettyRole()
    {
        switch ($this->role) {
            case self::ROLE_CITIZEN:
                return 'Житель';
            case self::ROLE_ADMINISTRATOR:
                return 'Администрация';
            case self::ROLE_GOD:
                return 'Админ системы';
            default:
                throw new Exception('Неизвестная роль пользователя');
        }
    }
}