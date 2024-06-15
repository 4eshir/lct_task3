<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\work\ObjectWork $model */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Загрузка МАФ из файла';
$this->params['breadcrumbs'][] = [
    'label' => 'Админ-панель',
    'url' => ['/backend/admin/index'],
];
$this->params['breadcrumbs'][] = ['label' => 'Объекты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="object-work-create main-block-admin">

    <h3><?= Html::encode($this->title) ?></h3>
    <br>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'xmlFile')->fileInput()->label('Выберите XML файл', ['style' => 'display: block;']); ?>

    <br>

    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']); ?>

    <?php ActiveForm::end(); ?>

</div>
