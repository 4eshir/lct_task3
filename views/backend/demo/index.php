<?php

use yii\helpers\Html;
?>

<div class="container1">
    <div class="block1">
        <h2 class="block-header">Генерация расстановок МАФ по заданным параметрам</h2>
        <img src="/img/filters-pic.jpg" class="block-image"/>
        <?= Html::a('Перейти к демо', ['generate'], ['class' => 'btn btn-primary block-btn']) ?>
    </div>
    <div class="block2">
        <h2 class="block-header">Генерация аналогов существующим расстановкам МАФ</h2>
        <img src="/img/analog-pic.png" class="block-image"/>
        <?= Html::a('Перейти к демо', ['analog'], ['class' => 'btn btn-primary block-btn']) ?>
    </div>
    <div class="block3">
        <h2 class="block-header">Генерация расстановок МАФ по шаблонам</h2>
        <img src="/img/template-pic.jpg" class="block-image" style="margin-bottom: 0"/>
        <?= Html::a('Перейти к демо', ['/frontend/administration/templates'], ['class' => 'btn btn-primary block-btn']) ?>
    </div>
</div>


<style>
    .container1 {
        display: flex;
    }

    .block1 {
        width: 30%;
        margin-right: 5%;
        margin-top: 20px;
        height: 600px;
        border: 0.1px solid white;
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 15px #644bb1;
        border-radius: 15px;

        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .block2 {
        width: 30%;
        margin-right: 5%;
        margin-top: 20px;
        height: 600px;
        border: 0.1px solid white;
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 15px #644bb1;
        border-radius: 15px;

        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .block3 {
        width: 30%;
        margin-top: 20px;
        height: 600px;
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
        margin-bottom: 30px;
        width: 300px;

        display: inline-block;
        margin-top: auto;


        border-radius: 10px;
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
        margin-bottom: 20px;

        display: inline-block;
        margin-top: auto; /* Выравнивает кнопку по нижнему краю блока */
    }

    .block-btn:hover {
        background-color: #361967;
        border: 1px solid #220b49;
    }
</style>
