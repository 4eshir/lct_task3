<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\SearchQuestionnaireWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="questionnaire-work-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'ages_interval_id') ?>

    <?= $form->field($model, 'sport_tendency') ?>

    <?= $form->field($model, 'recreation_tendency') ?>

    <?php // echo $form->field($model, 'game_tendency') ?>

    <?php // echo $form->field($model, 'education_tendency') ?>

    <?php // echo $form->field($model, 'arrangement_matrix') ?>

    <?php // echo $form->field($model, 'territory_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
