<?php

/** @var yii\web\View $this */
/** @var app\models\User $model */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h1 style="margin-bottom: 0.5em">Выберите пользователя</h1>
<?php foreach ($model as $user): ?>
    <div style="margin-bottom: 1em">
        <?= Html::a($user->login, Url::to(['/user/change-user', 'id' => $user->id]), ['class' => $user->auth_flag === 1 ? 'btn btn-success' : 'btn btn-primary']); ?>
    </div>
<?php endforeach; ?>