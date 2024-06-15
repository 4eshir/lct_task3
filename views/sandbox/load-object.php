<?php

/** @var yii\web\View $this */
/** @var app\models\forms\sandbox\LoadObjectForm $model */
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
        <span class="param-name">name*</span>: наименование объекта<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Строка UNICODE</li>
        </ul>
        <span class="param-name">width*</span>: ширина объекта (в см)<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Целое число сантиметров (округление в большую сторону)</li>
        </ul>
        <span class="param-name">length*</span>: длина объекта (в см)<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Целое число сантиметров (округление в большую сторону)</li>
        </ul>
        <span class="param-name">height*</span>: высота объекта (в см)<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Целое число сантиметров (округление в большую сторону)</li>
        </ul>
        <span class="param-name">cost*</span>: стоимость (в руб)<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Целое число сантиметров (округление в большую сторону)</li>
        </ul>
        <span class="param-name">object_type_id*</span>: ID типа объекта<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>1 - Рекреационный</li>
            <li>2 - Спортивный</li>
            <li>3 - Развивающий</li>
            <li>4 - Игровой</li>
        </ul>
        <span class="param-name">creator*</span>: производитель<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Строка UNICODE</li>
        </ul>
        <span class="param-name">article*</span>: артикул<br>
        <ul>
            <li>Обязательный параметр</li>
            <li>Строка UNICODE</li>
        </ul>
        <span class="param-name">left_age</span>: минимальный возраст<br>
        <ul>
            <li>Целое число</li>
            <li>Не меньше 0</li>
        </ul>
        <span class="param-name">right_age</span>: максимальный возраст<br>
        <ul>
            <li>Целое число</li>
            <li>Не меньше left_age</li>
        </ul>
        <span class="param-name">created_time</span>: время создания<br>
        <ul>
            <li>Целое число</li>
            <li>Не меньше 0</li>
            <li>Кол-во дней, необходимых на создание МАФ</li>
        </ul>
        <span class="param-name">install_time</span>: время установки<br>
        <ul>
            <li>Целое число</li>
            <li>Не меньше 0</li>
            <li>Кол-во дней, необходимых для установки МАФ</li>
        </ul>
        <span class="param-name">worker_count</span>: кол-во работников для установки МАФ<br>
        <ul>
            <li>Целое число</li>
            <li>Не меньше 0</li>
            <li>Кол-во работников, необходимых для установки МАФ</li>
        </ul>
        <span class="param-name">dead_zone_size</span>: доп. безопасная зона (в см)<br>
        <ul>
            <li>Целое число сантиметров (округление в большую сторону)</li>
            <li>Дополнительная зона безопасности вокруг объекта</li>
        </ul>
        <span class="param-name">style</span>: стиль объекта<br>
        <ul>
            <li>Строка UNICODE</li>
        </ul>

    </div>

    <?php $form = ActiveForm::begin(['id' => 'get-objects-form']); ?>

    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'width')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'length')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'height')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'cost')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'object_type_id')->dropDownList(
        [
            1 => '1 - Рекреационный',
            2 => '2 - Спортивный',
            3 => '3 - Развивающий',
            4 => '4 - Игровой',
        ]
    ) ?>
    <?= $form->field($model, 'creator')->textInput() ?>
    <?= $form->field($model, 'article')->textInput() ?>
    <?= $form->field($model, 'left_age')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'right_age')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'created_time')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'install_time')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'worker_count')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'dead_zone_size')->textInput(['type' => 'number']) ?>
    <?= $form->field($model, 'style')->textInput() ?>

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