<?php

/** @var yii\web\View $this */
/** @var app\models\forms\sandbox\GenerateArrangementForm $model */
/** @var yii\widgets\ActiveForm $form */

use app\components\arrangement\TerritoryConcept;
use app\facades\TerritoryFacade;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="main-block-sand">
    <?= Html::a('Вернуться к документации', ['/api/doc']) ?><br>
    <div class="description-block-query">
        <p>URL: <b>/api/generate-arrangement</b></p>
        <span class="param-name">tId*</span>: ID дворовой территории<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>ID территории (можно получить из /api/get-territories)</li>
        </ul>
        <span class="param-name">genType*</span>: основной тип генерации<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>'base' - генерация на базовых весах по возрастам</li>
            <li>'change' - генерация на персонализированных весах относительно территории</li>
            <li>'self' - генерация неа основе личного голосования пользователя</li>
        </ul>
        <span class="param-name">addGenType</span>: дополнительный тип генерации<br>
        <ul>
            <li>0 - базовый тип генерации</li>
            <li>1 - максимально экономичная генерация</li>
            <li>2 - генерация расстановки, аналогичной предложенной</li>
        </ul>
        <span class="param-name">params</span>: дополнительные параметры<br>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'get-objects-form']); ?>

    <?= $form->field($model, 'tId')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'genType')->dropDownList(
        [
            TerritoryConcept::TYPE_BASE_WEIGHTS => 'base - генерация на базовых весах по возрастам',
            TerritoryConcept::TYPE_CHANGE_WEIGHTS => 'change - генерация на персонализированных весах относительно территории',
            TerritoryConcept::TYPE_SELF_VOTES => 'self - генерация неа основе личного голосования пользователя',
        ]
    ) ?>

    <?= $form->field($model, 'addGenType')->dropDownList(
        [
            TerritoryFacade::OPTIONS_DEFAULT => '0 - базовый тип генерации',
            TerritoryFacade::OPTIONS_BUDGET_ECONOMY => '1 - максимально экономичная генерация',
            TerritoryFacade::OPTIONS_SIMILAR => '2 - генерация расстановки, аналогичной предложенной',
        ]
    ) ?>

    <?= $form->field($model, 'params')->textInput() ?>

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