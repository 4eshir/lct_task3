<?php

use app\models\work\ObjectWork;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\search\SearchObjectWork $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Каталог МАФ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-work-index main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php echo $this->render('_search-objects', ['model' => $searchModel]); ?>

    <div style="margin-bottom: 10px">
        <?= Html::a('Загрузить объекты через XML', ['/backend/object/download-xml'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Выгрузить объекты в XML', ['/backend/object/upload-xml'], ['class' => 'btn btn-warning']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'name',
            'length',
            'width',
            'height',
            'cost',
            [
                'label' => 'Время изг.',
                'attribute' => 'created_time',
                'value' => function($model) {
                    return $model->created_time . ' д.';
                }
            ],
            [
                'label' => 'Время уст.',
                'attribute' => 'install_time',
                'value' => function($model) {
                    return $model->install_time . ' д.';
                }
            ],
            //'worker_count',
            [
                'attribute' => 'object_type_id',
                'value' => function($model) {
                    return $model->prettyType;
                }
            ],
            'creator',
            //'dead_zone_size',
            'style',
            //'model_path',
            [
                'class' => ActionColumn::className(),
                'template' => '{view}',
                'urlCreator' => function ($action, ObjectWork $model, $key, $index, $column) {
                    return Url::toRoute(['/backend/object/' . $action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
