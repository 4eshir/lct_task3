<?php

/** @var $model AdminLoginForm */

use app\models\forms\AdminLoginForm;
use app\models\work\TerritoryWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'login')->textInput()->label('Логин') ?>
<?= $form->field($model, 'password')->textInput(['type' => 'password'])->label('Пароль') ?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Авторизоваться', ['class' => 'btn btn-success', 'name' => 'decision-button']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>