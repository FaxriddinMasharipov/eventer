<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\SMijoz */
/* @var $form yii\widgets\ActiveForm */
?>

<div >
    <div class="smijoz-form">

        <div class="row" style="background-color: white; padding: 50px 50px 50px 50px">
            <div class="col-md-6">
                <div class="login100-pic js-tilt" style="margin-top: 120px" data-tilt>

                    <img src="<?=Yii::$app->request->baseUrl?>/temp/Login_v1/images/img-01.png" alt="IMG">

                </div>
            </div>
            <div class="col-md-6" style="text-align: center">
                <?php $form = ActiveForm::begin(); ?>
                <span class="login100-form-title" ><?php echo Yii::t('app','SIGNUP'); ?>

					</span>

                <div style=" margin-top: -20px" class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <?= $form->field($model, 'fio')->textInput(['placeholder'=>Yii::t('app','Name Surname'),'class'=>"input100"]) ?>
<!--                    <input class="input100" type="text" name="name" required autofocus placeholder="--><?php //echo Yii::t('app','Name Surname'); ?><!--">-->
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <?= $form->field($model, 'davlat')->textInput(['placeholder'=>Yii::t('app','Country'),'class'=>"input100"]) ?>
<!--                    <input class="input100" type="text" name="dav" placeholder="--><?php //echo Yii::t('app','Country'); ?><!--">-->
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <?= $form->field($model, 'tashkilot')->textInput(['placeholder'=>Yii::t('app','Сompany'),'class'=>"input100"]) ?>
<!--                    <input class="input100" type="text" name="tash" placeholder="--><?php //echo Yii::t('app','Сompany'); ?><!--">-->
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <?= $form->field($model, 'lavozim')->textInput(['placeholder'=>Yii::t('app','Activity'),'class'=>"input100"]) ?>
<!--                    <input class="input100" type="text" name="lav" placeholder="--><?php //echo Yii::t('app','Activity'); ?><!--">-->
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">

                    <?= $form->field($model, 'email')->textInput(['placeholder'=>Yii::t('app','E-mail'),'class'=>"input100"]) ?>

<!--                    <input class="input100" type="email" name="email" placeholder="--><?php //echo Yii::t('app','E-mail'); ?><!--">-->

                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">

<!--                    <input class="input100" type="text" name="tel" placeholder="--><?php //echo Yii::t('app','Phone'); ?><!--">-->
                    <?= $form->field($model, 'tel')->textInput(['placeholder'=>Yii::t('app','Phone'),'class'=>"input100"]) ?>
<!--                    <input type="text" name="count" value="--><?//=$model?><!--" hidden>-->
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">

                    <?= $form->field($model, 'message')->dropDownList([


                        '1'=> Yii::t('app','How did you hear about the exhibition (отметить / tick)'),
                        '2'=>Yii::t('app','radio'),
                        '3'=>Yii::t('app','e-mail sending'),
                        '4'=>Yii::t('app','outdoor advertising'),
                        '5'=>Yii::t('app','mailing'),
                        '6'=>Yii::t('app','Internet'),
                        '7'=>Yii::t('app','Оther'),


                    ],['class'=>"input100"]); ?>

<!--                    <select class="input100" required name = "sel">-->
<!--                        <option value="" disabled selected hidden></option>-->
<!--                        <option value="радио">--><?php //echo Yii::t('app','How did you hear about the exhibition (отметить / tick)'); ?><!--</option>-->
<!--                        <option value="ТВ ">--><?php //echo Yii::t('app','radio'); ?><!-- </option>-->
<!--                        <option value="рассылка e-mail ">--><?php //echo Yii::t('app','e-mail sending'); ?><!--</option>-->
<!--                        <option value="светодиодные экраны">--><?php //echo Yii::t('app','outdoor advertising'); ?><!--</option>-->
<!--                        <option value="рассылка почтой ">--><?php //echo Yii::t('app','mailing'); ?><!--</option>-->
<!--                        <option value=" наружная реклама">--><?php //echo Yii::t('app','Internet'); ?><!--</option>-->
<!--                        <option value="др "> --><?php //echo Yii::t('app','Оther'); ?><!--</option>-->
<!--                    </select>-->

                </div><?= $form->field($model, 'qrkod')->textInput(['value' => "IEG".(rand(1, 999999))]) ?>

                <div  style="text-align: center;">
                    <button style="text-align: center" class="login100-form-btn">
                        создать
                    </button>
                </div>


                <?php ActiveForm::end(); ?>
            </div>
        </div>


    </div>
</div>







<!--<div class="smijoz-form">-->
<!---->
<!--    --><?php //$form = ActiveForm::begin(); ?>
<!---->
<!---->
<!---->
<!--    --><?//= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'tashkilot')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'lavozim')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'lavozim_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'qrkod')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'user_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'new_date')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'site_date')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'slave_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'reg_date')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'tadbir_id')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'printer')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'pr_tur')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'mobile')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'davlat')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?//= $form->field($model, 'vvod_tur')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'forum')->textInput() ?>
<!---->
<!--    --><?//= $form->field($model, 'message')->textInput(['maxlength' => true]) ?>
<!---->
<!--    <div class="form-group">-->
<!--        --><?//= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
<!--    </div>-->
<!---->
<!--    --><?php //ActiveForm::end(); ?>
<!---->
<!--</div>-->
