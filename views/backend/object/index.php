<?php

use app\models\work\ObjectWork;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SearchObjectWork $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Объекты';
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-work-index main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новый объект', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Загрузить объекты через XML', ['download-xml'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Выгрузить объекты в XML', ['upload-xml'], ['class' => 'btn btn-warning']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'length',
            'width',
            'height',
            //'cost',
            //'created_time:datetime',
            //'install_time:datetime',
            //'worker_count',
            //'object_type_id',
            //'creator',
            //'dead_zone_size',
            //'style',
            //'model_path',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, ObjectWork $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
