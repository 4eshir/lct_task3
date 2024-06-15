<?php

namespace app\models\forms;

use app\models\work\UserWork;
use yii\base\Model;

class AdminLoginForm extends Model
{
    public $login;
    public $password;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'string'],
        ];
    }

    public function login()
    {
        $entity = UserWork::find()->where(['login' => $this->login])->andWhere(['password_hash' => md5($this->password)])->one();

        if ($entity) {
            $allUsers = UserWork::find()->all();
            foreach ($allUsers as $user) {
                $user->auth_flag = 0;
                $user->save();
            }

            $entity->auth_flag = 1;
            $entity->save();
            return true;
        }

        return false;
    }

    public function save()
    {

    }
}