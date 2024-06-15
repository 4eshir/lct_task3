<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\work\TerritoryWork $model */
/** @var app\models\work\NeighboringTerritoryWork $modelNeighbor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Список территорий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="territory-work-view main-block-admin">

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
            'address',
            'length',
            'width',
            [
                'attribute' => 'geo_coord',
                'value' => function($model) {
                    return '[' . $model->latitude . ' ; ' . $model->longitude . ']';
                }
            ]
        ],
    ]) ?>

    <br>
    <h2>Соседствующие территории</h2>
    <?php if (count($modelNeighbor) > 0): ?>
        <table class="table table-active">
            <tr>
                <td><b>Названия территорий</b></td>
                <?php foreach ($modelNeighbor as $item): ?>
                    <td>
                        <?= $item->neighboringTerritoryWork->name ?>
                    </td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td><b>Приоритетные направленности</b></td>
                <?php foreach ($modelNeighbor as $item): ?>
                    <td>
                        <?= $item->neighboringTerritoryWork->prettyPriorityType ?>
                    </td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td><b>Веса приоритетов</b></td>
                <?php foreach ($modelNeighbor as $item): ?>
                    <td>
                        <?= $item->neighboringTerritoryWork->prettyPriorityCoef ?>
                    </td>
                <?php endforeach; ?>
            </tr>

            <tr>
                <td><b>Ожидаемое влияние на расстановку МАФ на территории</b></td>
                <?php foreach ($modelNeighbor as $item): ?>
                    <td>
                        <?= $item->neighboringTerritoryWork->influence ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    <?php endif; ?>

</div>
