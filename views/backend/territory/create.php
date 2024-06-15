<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\work\TerritoryWork $model */

$this->title = 'Добавление новой территории';
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Список территорий', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="territory-work-create main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
