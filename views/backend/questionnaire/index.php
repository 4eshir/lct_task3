<?php

use app\models\work\AgesIntervalWork;
use app\models\work\QuestionnaireWork;
use app\models\work\TerritoryWork;
use app\models\work\UserWork;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SearchQuestionnaireWork $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Результаты опросов';
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-work-index main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return UserWork::find()->where(['id' => $model->user_id])->one()->login;
                }
            ],
            [
                'attribute' => 'ages_interval_id',
                'value' => function($model) {
                    $intervals = AgesIntervalWork::find()->where(['id' => $model->ages_interval_id])->one();
                    return $intervals->left_age . ' - ' .$intervals->right_age . ' л.';
                }
            ],

            [
                'label' => 'Приоритеты',
                'attribute' => 'tendency',
                'value' => function($model) {
                    return 'Рекреация: ' . $model->recreation_tendency . " / 10<br>" .
                        'Спорт: ' . $model->sport_tendency . " / 10<br>" .
                        'Развивающий: ' . $model->education_tendency . " / 10<br>" .
                        'Игровой: ' . $model->game_tendency . " / 10<br>";
                },
                'format' => 'raw',
            ],

            [
                'attribute' => 'territory_id',
                'value' => function($model) {
                    return TerritoryWork::find()->where(['id' => $model->territory_id])->one()->name;
                }
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, QuestionnaireWork $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
