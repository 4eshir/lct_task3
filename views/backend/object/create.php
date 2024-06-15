<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\work\ObjectWork $model */

$this->title = 'Добавление нового объекта';
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];$this->params['breadcrumbs'][] = ['label' => 'Объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="object-work-create main-block-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
