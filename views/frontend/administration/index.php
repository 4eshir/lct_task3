<?php

use yii\helpers\Html;
?>

<div class="container1">
    <div class="block1">
        <h1 class="block-header">Шаблоны</h1>
        <img src="/img/template-pic.png" class="block-image"/>
        <p class="block-text">Просмотрите список готовых шаблонов площадок и создайте свой</p>
        <?= Html::a('Перейти в Шаблоны', ['templates'], ['class' => 'btn btn-primary block-btn']) ?>
    </div>
    <div class="block2">
        <h1 class="block-header">Конструктор</h1>
        <img src="/img/constructor-pic.png" class="block-image"/>
        <p class="block-text">Соберите свою собственную площадку с нуля, в соответствие с вашими запросами</p>
        <?= Html::a('Перейти в Конструктор', ['choose-constructor'], ['class' => 'btn btn-primary block-btn']) ?>
    </div>
</div>


<style>
    .container1 {
        display: flex;
    }

    .block1 {
        width: 48%;
        margin-right: 4%;
        margin-top: 20px;
        height: 700px;
        border: 0.1px solid white;
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 15px #644bb1;
        border-radius: 15px;

        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .block2 {
        width: 48%;
        margin-top: 20px;
        height: 700px;
        border: 0.1px solid white;
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 15px #644bb1;
        border-radius: 15px;

        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .block-header {
        text-align: center;
        margin-top: 20px;
        color: white;
        font-family: "Nunito", sans-serif;
    }

    .block-image {
        margin-top: 30px;
        width: 350px;
        height: 300px;
    }

    .block-text {
        color: white;
        font-family: "Nunito", sans-serif;
        font-size: 24px;
        text-align: center;
        padding: 50px;
    }

    .block-btn {
        background-color: #644bb1;
        border: 1px solid #5c45a1;
        font-size: 22px;
        padding: 15px 25px 15px 25px;
        border-radius: 10px;
        font-family: "Nunito", sans-serif;
        font-weight: 700;
    }

    .block-btn:hover {
        background-color: #361967;
        border: 1px solid #220b49;
    }
</style>