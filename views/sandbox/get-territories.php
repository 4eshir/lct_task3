<?php

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="main-block-sand">
    <?= Html::a('Вернуться к документации', ['/api/doc']) ?><br>
    <div class="description-block-query">
        <p>URL: <b>/api/get-territories</b></p>
        <p><b>Параметры</b></p>
        <i>без параметров</i><br>
    </div>

    <?php $form = ActiveForm::begin(['id' => 'get-objects-form']); ?>

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