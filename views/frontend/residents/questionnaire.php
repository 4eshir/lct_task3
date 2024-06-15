<?php

/** @var $model QuestionForm */

use app\models\forms\QuestionForm;
use app\models\work\AgesIntervalWork;
use app\models\work\TerritoryWork;
use yii\helpers\Html;
use yii\jui\SliderInput;
use yii\widgets\ActiveForm;
?>


<?php $form = ActiveForm::begin() ?>

<div class="description-block">
    <div class="description-head"></div>
    <label class="main-label">Голосование за благоустройство придомовой территории</label>
    <br>
    <span class="description">Уважаемый житель города N, ответьте на несколько вопросов, касающихся детской площадки, которая будет располагаться на территории вашего двора</span>
</div>

<div class="question-block">
    <div class="question-head"></div>
    <label class="question-label">Выберите придомовую территорию вашего дома</label>
    <?= $form->field($model, 'territory')->dropDownList(TerritoryWork::GetAllTerritories())->label(false) ?>
</div>

<div class="question-block">
    <div class="question-head"></div>
    <label class="question-label">Выберите возрастную категорию голосующего</label>
    <?= $form->field($model, 'answerAge')->dropDownList(AgesIntervalWork::GetAllIntervals())->label(false) ?>
</div>

<div class="question-block">
    <div class="question-head"></div>
    <label class="question-label">Оцените приоритет <u>спортивных</u> объектов на площадке (от 1 до 10)</label>

    <div class=wrapper>
        <div class="range">
            <input type="range" min="1" max="10" value="0" id="questionform-answerssportcoef" name="QuestionForm[answersSportCoef]"/>
            <div class="value value1">1</div>
        </div>
    </div>

</div>

<div class="question-block">
    <div class="question-head"></div>
    <label class="question-label">Оцените приоритет <u>рекреационных</u> объектов на площадке (от 1 до 10)</label>

    <div class=wrapper>
        <div class="range">
            <input type="range" min="1" max="10" value="1" id="questionform-answersrecreationcoef" name="QuestionForm[answersRecreationCoef]"/>
            <div class="value value2">1</div>
        </div>
    </div>

</div>

<div class="question-block">
    <div class="question-head"></div>
    <label class="question-label">Оцените приоритет <u>игровых</u> объектов на площадке (от 1 до 10)</label>

    <div class=wrapper>
        <div class="range">
            <input type="range" min="1" max="10" value="1" id="questionform-answersgamecoef" name="QuestionForm[answersGameCoef]"/>
            <div class="value value3">1</div>
        </div>
    </div>

</div>

<div class="question-block">
    <div class="question-head"></div>
    <label class="question-label">Оцените приоритет <u>развивающих</u> объектов на площадке (от 1 до 10)</label>

    <div class=wrapper>
        <div class="range">
            <input type="range" min="1" max="10" value="1" id="questionform-answerseducationalcoef" name="QuestionForm[answersEducationalCoef]"/>
            <div class="value value4">1</div>
        </div>
    </div>

</div>

<div class="form-group">
    <div>
        <?= Html::submitButton('Перейти к выбору варианта', ['class' => 'btn btn-success btn-custom', 'name' => 'decision-button']) ?>
    </div>
</div>


<?php ActiveForm::end() ?>
