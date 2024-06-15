<?php

use app\models\work\AgesIntervalWork;
use app\models\work\TerritoryWork;
use app\models\work\UserWork;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\work\QuestionnaireWork $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Результаты опросов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="questionnaire-work-view main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
        ],
    ]) ?>

</div>
