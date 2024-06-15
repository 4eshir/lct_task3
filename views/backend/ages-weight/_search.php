<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\SearchAgesWeightWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ages-weight-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'self_weight') ?>

    <?= $form->field($model, 'sport_weight') ?>

    <?= $form->field($model, 'game_weight') ?>

    <?= $form->field($model, 'education_weight') ?>

    <?php // echo $form->field($model, 'recreation_weight') ?>

    <?php // echo $form->field($model, 'ages_interval_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
