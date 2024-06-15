<?php

use app\models\work\AgesIntervalWork;
use app\models\work\AgesWeightWork;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SearchAgesWeightWork $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Приоритетные веса по возрастам';
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ages-weight-work-index main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            [
                'attribute' => 'ages_interval_id',
                'value' => function($model) {
                    $intervals = AgesIntervalWork::find()->where(['id' => $model->ages_interval_id])->one();
                    return $intervals->left_age . ' - ' .$intervals->right_age . ' л.';
                }
            ],
            'sport_weight',
            'game_weight',
            'education_weight',
            'recreation_weight',

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update}',
                'urlCreator' => function ($action, AgesWeightWork $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
