<?php

use app\models\work\ObjectTypeWork;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\work\ObjectWork $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="object-work-view main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'article',
            'length',
            'width',
            'height',
            'cost',
            'created_time:datetime',
            'install_time:datetime',
            'worker_count',
            'age',
            [
                'attribute' => 'object_type_id',
                'value' => function($model) {
                    return ObjectTypeWork::find()->where(['id' => $model->object_type_id])->one()->name;
                },
            ],
            'creator',
            'dead_zone_size',
            'style',
            'model_path',
        ],
    ]) ?>

</div>
