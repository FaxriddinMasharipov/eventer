<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body style=' background: #9053c7;
  background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
  background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
  background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
  background: linear-gradient(-135deg, #c850c0, #4158d0);'>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="container" style="margin-top: 15px">
    <div class="topnav" >
        <a  href="<?=\yii\helpers\Url::to(['/site/language?lang=en'])?>">En</a>
        <a  href="<?=\yii\helpers\Url::to(['/site/language?lang=ru'])?>">Ru</a>
        <a href="<?=\yii\helpers\Url::to(['/site/language?lang=uz'])?>">Uz</a>

    </div>
    </div>



    <div class="container" style="margin-top: 0px" >
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

    <!--<footer class="footer">-->
    <!--    <div class="container">-->
    <!--        <p class="pull-left">&copy; --><?//= Html::encode(Yii::$app->name) ?><!-- --><?//= date('Y') ?><!--</p>-->
    <!---->
    <!--        <p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
    <!--    </div>-->
    <!--</footer>-->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<style>
    body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }

    .topnav {
        overflow: hidden;

    }

    .topnav a {
        float: right;
        color: #f2f2f2;
        text-align: center;
        padding: 0px 10px;
        text-decoration: none;
        font-size: 17px;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .topnav a.active {
        background-color: #4CAF50;
        color: white;
    }
</style>