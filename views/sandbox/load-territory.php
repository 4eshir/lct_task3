<?php

/** @var yii\web\View $this */
/** @var app\models\forms\sandbox\LoadTerritoryForm $model */
/** @var yii\widgets\ActiveForm $form */

use app\components\arrangement\TerritoryConcept;
use app\facades\TerritoryFacade;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="main-block-sand">
    <?= Html::a('Вернуться к документации', ['/api/doc']) ?><br>
    <div class="description-block-query">
        <p>URL: <b>/api/load-object</b></p>
        <span class="param-name">name*</span>: наименование дворовой территории<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Строка UNICODE</li>
        </ul>
        <span class="param-name">width*</span>: ширина территории (в см)<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Целое число сантиметров (округление в большую сторону)</li>
        </ul>
        <span class="param-name">length*</span>: длина территории (в см)<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Целое число сантиметров (округление в большую сторону)</li>
        </ul>
        <span class="param-name">address*</span>: физический адрес расположения территории<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Строка UNICODE</li>
        </ul>
        <span class="param-name">latitude*</span>: географическая широта<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Число с плавающей точкой двойной точности (double)</li>
        </ul>
        <span class="param-name">longitude*</span>: географическая долгота<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Число с плавающей точкой двойной точности (double)</li>
        </ul>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'get-objects-form']); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'width')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'length')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'address')->textInput() ?>
    <?= $form->field($model, 'latitude')->textInput(['type' => 'number', 'step' => '0.0000001']) ?>
    <?= $form->field($model, 'longitude')->textInput(['type' => 'number', 'step' => '0.0000001']) ?>

    <div class="form-group">
        <?= Html::submitButton('Выполнить запрос', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <div class="result-data">

    </div>

</div>

<?php
$this->registerJs(
    "$(function(){
        $('form').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    let jsonData = JSON.parse(response);
                    jsonData = JSON.stringify(jsonData, null, 2);
                    $('.result-data').show();
                    $('.result-data').html('<p><b>Результат выполнения запроса</b></p><div class=\"data-block\"><pre>' + jsonData + '</div></pre>');
                }
            });
        });
    });"
)
?>