<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\SMijoz */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Smijozs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smijoz-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fio',
            'email:email',
            'tashkilot',
            'lavozim',
            'lavozim_id',
            'tel',
            'qrkod',
            'user_id',
            'new_date',
            'site_date',
            'slave_id',
            'reg_date',
            'tadbir_id',
            'printer',
            'pr_tur',
            'mobile',
            'davlat',
            'vvod_tur',
            'forum',
            'message',
        ],
    ]) ?>

</div>
