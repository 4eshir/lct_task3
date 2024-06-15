<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\work\QuestionnaireWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="questionnaire-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'ages_interval_id')->textInput() ?>

    <?= $form->field($model, 'sport_tendency')->textInput() ?>

    <?= $form->field($model, 'recreation_tendency')->textInput() ?>

    <?= $form->field($model, 'game_tendency')->textInput() ?>

    <?= $form->field($model, 'education_tendency')->textInput() ?>

    <?= $form->field($model, 'arrangement_matrix')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'territory_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
