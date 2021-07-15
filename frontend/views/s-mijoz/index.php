<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SMijozSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Smijozs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="smijoz-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Smijoz', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'fio',
            'email:email',
            'tashkilot',
            'lavozim',
            //'lavozim_id',
            //'tel',
            //'qrkod',
            //'user_id',
            //'new_date',
            //'site_date',
            //'slave_id',
            //'reg_date',
            //'tadbir_id',
            //'printer',
            //'pr_tur',
            //'mobile',
            //'davlat',
            //'vvod_tur',
            //'forum',
            //'message',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
