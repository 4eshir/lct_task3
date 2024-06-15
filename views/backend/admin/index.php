<?php

/** @var $model ChooseTerritoryForm */

use app\models\forms\ChooseTerritoryForm;
use app\models\work\AgesWeightWork;
use app\models\work\ObjectWork;
use app\models\work\QuestionnaireWork;
use app\models\work\TerritoryWork;
use app\models\work\UserWork;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="container-admin">
    <div class="main-block">
        <h3 class="head-label"><u>Редактируемые списки</u></h3>

        <ul class="category-list">
            <li><?= Html::a('Территории', ['/backend/territory/index']) ?><span><?= TerritoryWork::find()->count() ?></span></li>
            <li><?= Html::a('Объекты', ['/backend/object/index']) ?><span><?= ObjectWork::find()->count() ?></span></li>
            <li><?= Html::a('Пользователи', ['/backend/user/index']) ?><span><?= UserWork::find()->count() ?></span></li>
            <li><?= Html::a('Результаты опросов', ['/backend/questionnaire/index']) ?><span><?= QuestionnaireWork::find()->count() ?></span></li>
            <li><?= Html::a('Приоритетные веса по возрастам', ['/backend/ages-weight/index']) ?><span><?= AgesWeightWork::find()->count() ?></span></li>
        </ul>
    </div>

    <div class="main-block">
        <h3 class="head-label"><u>Демонстрационные примеры</u></h3>

        <ul class="category-list">
            <li><?= Html::a('Генератор расстановок МАФ по заданным параметрам', ['/backend/demo/generate']) ?></li>
            <li><?= Html::a('Генератор аналогов существующим расстановок МАФ', ['/backend/demo/analog']) ?></li>
            <li><?= Html::a('Генератор расстановок МАФ по шаблонам', ['/frontend/administration/templates']) ?></li>
        </ul>
    </div>
</div>



<style>
    .head-label {
        margin-bottom: 20px;
    }

    .container-admin {
        display: flex;
        justify-content: space-between; /* Добавляет равное расстояние между блоками */
        margin: 0 auto; /* Центрирует контейнер на странице */
        max-width: 100%; /* Примерная ширина контейнера, можно изменить под свои нужды */
    }


    .main-block {
        margin: 10px;
        padding: 10px;
        border: 1px solid white;
        width: 48%;
        background-color: #88b5f2;
        border-radius: 5px;
        height: fit-content;
    }

    .category-list * {transition: .4s linear;}
    .category-list {
        background: white;
        list-style-type: circle;
        list-style-position: inside;
        padding: 0 10px;
        margin: 0;
        width: 100%;
        border-radius: 5px;
    }
    .category-list li {
        border-bottom: 1px solid #efefef;
        padding: 10px 0;
    }
    .category-list a {
        text-decoration: none;
        color: #555;
        font-family: "Nunito", sans-serif;
        font-size: 18px;
    }
    .category-list li span {
        float: right;
        display: inline-block;
        border: 1px solid #efefef;
        padding: 0 5px;
        font-size: 16px;
        color: #999;
    }
    .category-list li:hover a {color: #cf5d7d;}
    .category-list li:hover span {
        color: #cf5d7d;
        border: 1px solid #cf5d7d;
    }
</style>