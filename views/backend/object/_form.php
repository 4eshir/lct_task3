<?php

use app\models\work\ObjectTypeWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\work\ObjectWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="object-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article')->textInput() ?>

    <?= $form->field($model, 'length')->textInput() ?>

    <?= $form->field($model, 'width')->textInput() ?>

    <?= $form->field($model, 'height')->textInput() ?>

    <?= $form->field($model, 'cost')->textInput() ?>

    <?= $form->field($model, 'created_time')->textInput() ?>

    <?= $form->field($model, 'install_time')->textInput() ?>

    <?= $form->field($model, 'worker_count')->textInput() ?>

    <?= $form->field($model, 'left_age')->textInput() ?>
    <?= $form->field($model, 'right_age')->textInput() ?>

    <?= $form->field($model, 'object_type_id')->dropDownList(ObjectTypeWork::GetAllTypes()) ?>

    <?= $form->field($model, 'creator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dead_zone_size')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
