<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\SMijoz */

    //$this->title = 'Create Smijoz';
    //$this->params['breadcrumbs'][] = ['label' => 'Smijozs', 'url' => ['index']];
    //$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smijoz-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
