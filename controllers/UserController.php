<?php

namespace app\controllers;

use app\models\common\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        Yii::$app->session->set('header-active', 'user');

        $model = User::find()->where(['!=', 'role', 3])->all();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionChangeUser($id)
    {
        $users = User::find()->all();
        foreach ($users as $user) {
            $user->auth_flag = null;
            $user->save();
        }

        $user = User::find()->where(['id' => $id])->one();
        $user->auth_flag = 1;
        $user->save();

        return $this->redirect(['index']);
    }

    public function actionProfile($id)
    {
        $model = User::find()->where(['id' => $id])->one();

        return $this->render('profile', [
            'model' => $model,
        ]);
    }
}