<?php

/** @var yii\web\View $this */
/** @var app\models\forms\sandbox\GetRealWeightsForm $model */
/** @var yii\widgets\ActiveForm $form */

use app\models\work\AgesWeightChangeableWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="main-block-sand">
    <?= Html::a('Вернуться к документации', ['/api/doc']) ?><br>
    <div class="description-block-query">
        <p>URL: <b>/api/get-real-weights</b></p>
        <p><b>Параметры</b></p>
        <span class="param-name">tId*</span>: ID дворовой территории<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>ID территории (можно получить из /api/get-territories)</li>
        </ul>
        <span class="param-name">weightsType</span>: тип веса<br>
        <ul>
            <li>'recreation' - рекреационный тип</li>
            <li>'sport' - спортивный тип</li>
            <li>'education' - образовательный тип</li>
            <li>'game' - игровой тип</li>
        </ul>
        <span class="param-name">agesInterval</span>: возрастной интервал<br>
        <ul>
            <li>1 - от 0 до 7 лет</li>
            <li>2 - от 8 до 12 лет</li>
            <li>3 - от 13 до 18 лет</li>
            <li>4 - от 19 до 30 лет</li>
            <li>5 - от 31 до 55 лет</li>
            <li>6 - от 56 лет</li>
        </ul>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'get-objects-form']); ?>

    <?= $form->field($model, 'tId')->textInput(['type' => 'number'])?>

    <?= $form->field($model, 'weightsType')->dropDownList([
        AgesWeightChangeableWork::RECREATION_COEF => 'recreation',
        AgesWeightChangeableWork::SPORT_COEF => 'sport',
        AgesWeightChangeableWork::EDUCATIONAL_COEF => 'education',
        AgesWeightChangeableWork::GAME_COEF => 'game',
    ], ['prompt' => ''])?>

    <?= $form->field($model, 'agesInterval')->dropDownList([
        1 => '1 - от 0 до 7 лет',
        2 => '2 - от 8 до 12 лет',
        3 => '3 - от 13 до 18 лет',
        4 => '4 - от 19 до 30 лет',
        5 => '5 - от 31 до 55 лет',
        6 => '6 - от 56 лет',
    ], ['prompt' => ''])?>

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