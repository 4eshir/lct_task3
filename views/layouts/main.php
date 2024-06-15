<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\models\work\UserWork;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php

$user = UserWork::getAuthUser();
$username = $user ? $user->login : '---';

?>
<header id="header">

    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/img/logo.png', ['alt'=>'SA', 'class'=>'logo-class']),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md fixed-top']
    ]);

    $headerActive = Yii::$app->session->get('header-active');

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            [
                'label' => 'Каталог МАФ',
                'url' => ['/frontend/residents/objects-list'],
                'linkOptions' => ['class' => $headerActive == 'objects' ? 'header-link-active' : 'header-link'],
                'options' => ['class' => $headerActive == 'objects' ? 'custom-li-class' : 'default-li-class']
            ],
            [
                'label' => 'Голосование',
                'url' => ['/frontend/residents/start-questionnaire'],
                'linkOptions' => ['class' => $headerActive == 'residents' ? 'header-link-active' : 'header-link'],
                'options' => ['class' => $headerActive == 'residents' ? 'custom-li-class' : 'default-li-class']
            ],
            [
                'label' => 'Администрация',
                'url' => ['/frontend/administration/index'],
                'linkOptions' => ['class' => $headerActive == 'administration' ? 'header-link-active' : 'header-link'],
                'options' => ['class' => $headerActive == 'administration' ? 'custom-li-class' : 'default-li-class']
            ],
            [
                'label' => 'Админ-панель',
                'url' => ['/site/admin-login'],
                'linkOptions' => ['class' => $headerActive == 'admin-login' ? 'header-link-active' : 'header-link'],
                'options' => ['class' => $headerActive == 'admin-login' ? 'custom-li-class' : 'default-li-class']
            ],
            [
                'label' => 'Разработчикам',
                'url' => ['/api/doc'],
                'linkOptions' => ['class' => $headerActive == 'api' ? 'header-link-active' : 'header-link'],
                'options' => ['class' => $headerActive == 'api' ? 'custom-li-class' : 'default-li-class']
            ],
            [
                'label' => 'Демо',
                'url' => ['/backend/demo/index'],
                'linkOptions' => ['class' => $headerActive == 'demo' ? 'header-link-active' : 'header-link'],
                'options' => ['class' => $headerActive == 'demo' ? 'custom-li-class' : 'default-li-class']
            ],
            [
                'label' => $username == '---' ? '---' : "Выйти ($username)",
                'url' => ['/site/logout'],
                'linkOptions' => ['class' => 'header-link-button'],
            ],
        ]
    ]);
    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Oompa_Loompas <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
