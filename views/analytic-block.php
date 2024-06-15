<?php

/** @var $model \app\models\forms\AnalyticModel */
?>


<div class="analytic-block">
    <p><b>Общая стоимость:</b> <?= $model->summaryCost ?> ₽</p>
    <p><b>Максимальное время производства МАФ:</b> <?= $model->createdTimeSequence ?> д.</p>
    <p><b>Минимальное время производства МАФ:</b> <?= $model->createdTimeParallel ?> д.</p>
    <p><b>Максимальное время установки:</b> <?= $model->installTimeSequence ?> д.</p>
    <p><b>Минимальное время установки:</b> <?= $model->installTimeParallel ?> д.</p>
    <p><b>Необходимо работников для установки (при условии разных работников на каждый МАФ):</b> <?= $model->workersCount ?> ч.</p>
    <p><b>Производители:</b> <?= $model->getPrettyCreators() ?></p>
    <p><b>Стиль:</b> <?= $model->getPrettyStyle() ?></p>
</div>


<style>
    .analytic-block {
        border-radius: 10px;
        background-color: #f5f5f5;
        padding: 10px;
        margin-top: 10px;
        margin-bottom: 10px;
        width: 100%;
    }

    .analytic-block > p {
        font-family: "Nunito", sans-serif;
        font-size: 16px;
    }
</style>