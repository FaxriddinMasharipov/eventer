<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SMijozSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="smijoz-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'fio') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'tashkilot') ?>

    <?= $form->field($model, 'lavozim') ?>

    <?php // echo $form->field($model, 'lavozim_id') ?>

    <?php // echo $form->field($model, 'tel') ?>

    <?php // echo $form->field($model, 'qrkod') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'new_date') ?>

    <?php // echo $form->field($model, 'site_date') ?>

    <?php // echo $form->field($model, 'slave_id') ?>

    <?php // echo $form->field($model, 'reg_date') ?>

    <?php // echo $form->field($model, 'tadbir_id') ?>

    <?php // echo $form->field($model, 'printer') ?>

    <?php // echo $form->field($model, 'pr_tur') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'davlat') ?>

    <?php // echo $form->field($model, 'vvod_tur') ?>

    <?php // echo $form->field($model, 'forum') ?>

    <?php // echo $form->field($model, 'message') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
