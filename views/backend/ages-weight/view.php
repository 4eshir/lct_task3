<?php

use app\models\work\AgesIntervalWork;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\work\AgesWeightWork $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Приоритетные веса по возрастам', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ages-weight-work-view main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'ages_interval_id',
                'value' => function($model) {
                    $intervals = AgesIntervalWork::find()->where(['id' => $model->ages_interval_id])->one();
                    return $intervals->left_age . ' - ' .$intervals->right_age . ' л.';
                }
            ],
            'self_weight',
            'sport_weight',
            'game_weight',
            'education_weight',
            'recreation_weight',

        ],
    ]) ?>

</div>
