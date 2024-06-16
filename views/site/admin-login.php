<?php

/** @var $model AdminLoginForm */

use app\models\forms\AdminLoginForm;
use app\models\work\TerritoryWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="admin-login-block">
    <?php $form = ActiveForm::begin() ?>

    <label>Логин</label>
    <?= $form->field($model, 'login')->textInput()->label(false) ?>

    <label>Пароль</label>
    <?= $form->field($model, 'password')->textInput(['type' => 'password'])->label(false) ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-light btn-log', 'name' => 'decision-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end() ?>
</div>


<style>
    .admin-login-block {
        border-radius: 10px;
        background-color: #644bb2;
        padding: 10px;
        margin-top: 10px;
        border: 1px solid #3c2188;
        width: 50%;
    }

    .btn-log {
        margin-top: 10px;
        width: 100%;
    }

    label {
        color: white;
        font-family: "Nunito", sans-serif;
        font-size: 16px;
    }

    .btn-light:hover {
        background-color: #88b6f4;
        border: 1px solid #88b6f4;
    }
</style>