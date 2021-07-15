<?php

use yii\helpers\Url;
/**
 * Created by PhpStorm.
 * User: MRK
 * Date: 26.10.2018
 * Time: 13:09
 */

?>

<div class="row" style="background-color: white; padding: 50px 50px 50px 50px">

    <div class="col-md-12" style="text-align: center">
        <h3 style="font-family: cursive"><?php echo Yii::t('app',"Thank you for registration. Show the picture below when entering the exhibition."); ?>

        </h3>

        <div style=" margin-top: 8px" class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">

            <img src="<?=Yii::$app->request->baseUrl?>/image/<?=$post?>.png" style="width: 60%" class="img-thumbnail">

        </div>
        <?php $form = \yii\bootstrap\ActiveForm::begin(['action'=>['site/send']]); ?>
        <input type="text" value="<?=$post?>.png" hidden name="qrcode">
        <input type="text" value="<?=$email?>" hidden name="email">

        <a  class="btn btn-info" download="download" href="<?=Yii::$app->request->baseUrl?>/image/<?=$post?>.png"><h3 style="text-align: center; font-family: cursive" > <?php echo Yii::t('app',"Download"); ?></h3></a>
       
        <?php $form = \yii\bootstrap\ActiveForm::end(); ?>
    </div>
</div>
