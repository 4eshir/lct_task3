<?php

/** @var $model ChooseTerritoryForm */

use app\models\forms\ChooseTerritoryForm;
use app\models\work\TerritoryWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<?php $form = ActiveForm::begin() ?>

<?= $form->field($model, 'territoryId')->dropDownList(TerritoryWork::GetAllTerritories()) ?>

<div class="form-group">
    <div>
        <?= Html::submitButton('Перейти к конструктору площадки', ['class' => 'btn btn-success', 'name' => 'decision-button']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>
