<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\work\AgesWeightWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="ages-weight-work-">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'self_weight')->textInput() ?>

    <?= $form->field($model, 'sport_weight')->textInput() ?>

    <?= $form->field($model, 'game_weight')->textInput() ?>

    <?= $form->field($model, 'education_weight')->textInput() ?>

    <?= $form->field($model, 'recreation_weight')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
