<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\work\AgesWeightWork $model */

$this->title = 'Редактировать веса: ' . $model->id;
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Приоритетные веса по возрастам', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="ages-weight-work-update main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
