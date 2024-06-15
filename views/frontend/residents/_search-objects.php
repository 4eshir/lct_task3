<?php

use app\models\work\ObjectWork;
use kartik\select2\Select2;use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\search\SearchObjectWork $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="object-work-search">

    <div class="filter-block">
        <?php $form = ActiveForm::begin([
            'action' => ['objects-list'],
            'method' => 'get',
            'id' => 'searchForm',
        ]); ?>

        <?= $form->field($model, 'targetId')->dropDownList(ArrayHelper::map(ObjectWork::find()->all(), 'id', 'name'), ['prompt' => ''])->label('Исходный МАФ') ?>

        <div class="targetObjectBlock"></div>

        <?= $form->field($model, 'flType')->dropDownList([
            1 => 'Найти максимально схожие МАФ',
            2 => 'Найти достаточно схожие МАФ',
            3 => 'Найти немного схожие МАФ',
        ], ['prompt' => ''])->label('Поиск аналогичных МАФ') ?>
    </div>

    <div class="filter-block">
        <?= $form->field($model, 'excludeCreators')->widget(Select2::classname(), [
            'data' => ObjectWork::getAllCreators(),
            'language' => 'ru',
            'options' => [
                'placeholder' => 'Выберите одного или нескольких поставщиков...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Исключить МАФ выбранных поставщиков'); ?>

        <?= $form->field($model, 'includeCreators')->widget(Select2::classname(), [
            'data' => ObjectWork::getAllCreators(),
            'language' => 'ru',
            'options' => [
                'placeholder' => 'Выберите одного или нескольких поставщиков...',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label('Показать МАФ только выбранных поставщиков'); ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить фильтры', Url::to(['/frontend/residents/objects-list'])) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$id = Html::getInputId($model, 'targetId');
$url = Url::toRoute(['/frontend/residents/update-target-object']);
$this->registerJs(
    "$('#".$id."').change(function() {
        var targetId = $(this).val();

        $.ajax({
            url: '".$url."',
            type: 'GET',
            data: {targetId: targetId},
            success: function(response) {
                $('.targetObjectBlock').html(response);
            },
            error: function() {
                console.log('An error occurred during the AJAX request.');
            }
        });
    });"
);

$this->registerJs(
    "$(document).ready(function() {
        var targetId = $('#searchobjectwork-targetid').val();
    
        if (targetId) {
            $.ajax({
                url: '".$url."',
                type: 'GET',
                data: {targetId: targetId},
                success: function(response) {
                    $('.targetObjectBlock').html(response);
                },
                error: function() {
                    console.log('An error occurred during the AJAX request.');
                }
            });
        }
    });"
);
?>

<style>
    .filter-block {
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #0d6efd;
        margin-bottom: 20px;
    }
</style>
