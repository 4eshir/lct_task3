<?php

use app\models\work\MunicipalityWork;
use app\models\work\UserWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\work\UserWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'municipality_id')->dropDownList(MunicipalityWork::GetAllMunicipalities(), ['prompt' => '---']) ?>

    <?= $form->field($model, 'role')->dropDownList(UserWork::GetAllRoles()) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
