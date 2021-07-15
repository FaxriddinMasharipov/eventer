<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */

$this->title = '';
$all=\frontend\models\AppsCountries::find()->all();
$data = \yii\helpers\ArrayHelper::map($all,'id','country_name');
$obl=\frontend\models\obl::find()->all();
$dataobl = \yii\helpers\ArrayHelper::map($obl,'id','name');
?>
<?php $form = ActiveForm::begin(['action'=>['site/qrcode']]); ?>



<style>

.login100-form-btn:active {
   opacity: 0.6;
}
@media(max-width:370px) {
    .login100-form-btn{
       left: 120%;
    }
    b{
        font-size: 32px;
    }
    .topnav{
        margin-right: 20px;
    }
}

@media(max-width:470px) {
    .login100-form-btn{
       left: 120%;
    }
    b{
        font-size: 32px;
    }
    .topnav{
        margin-right: 60px;
    }
}

@media(max-width:570px) {
    .login100-form-btn{
       left: 120%;
    }
    b{
        font-size: 32px;
    }
    .topnav{
        margin-right: 95px;
    }
}

.topnav a{
    margin-right: 10px;
    border: 1px solid darkblue;
    font-weight: 700;
}
.topnav a:active{
    transition: 0.5s;
    opacity: 0.5;
}

    .inputGroup {
        background-color: #fff;
        display: block;
        margin: 10px 0;
        position: relative;

    label {
        padding: 12px 30px;
        width: 100%;
        display: block;
        text-align: left;
        color: #3C454C;
        cursor: pointer;
        position: relative;
        z-index: 2;
        transition: color 200ms ease-in;
        overflow: hidden;

    &:before {
         width: 10px;
         height: 10px;
         border-radius: 50%;
         content: '';
         background-color: #5562eb;
         position: absolute;
         left: 50%;
         top: 50%;
         transform: translate(-50%, -50%) scale3d(1, 1, 1);
         transition: all 300ms cubic-bezier(0.4, 0.0, 0.2, 1);
         opacity: 0;
         z-index: -1;
     }

    &:after {
         width: 32px;
         height: 32px;
         content: '';
         border: 2px solid #D1D7DC;
         background-color: #fff;
         background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
         background-repeat: no-repeat;
         background-position: 2px 3px;
         border-radius: 50%;
         z-index: 2;
         position: absolute;
         right: 30px;
         top: 50%;
         transform: translateY(-50%);
         cursor: pointer;
         transition: all 200ms ease-in;
     }
    }

    input:checked ~ label {
        color: #fff;

    &:before {
         transform: translate(-50%, -50%) scale3d(56, 56, 1);
         opacity: 1;
     }

    &:after {
         background-color: #54E0C7;
         border-color: #54E0C7;
     }
    }

    input {
        width: 32px;
        height: 32px;
        order: 1;
        z-index: 2;
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        visibility: hidden;
    }
    }


    // codepen formatting
       .form {
           padding: 0 16px;
           max-width: 550px;
           margin: 50px auto;
           font-size: 18px;
           font-weight: 600;
           line-height: 36px;
       }

    body {
        background-color: #D1D7DC;
        font-family: 'Fira Sans', sans-serif;
    }

    *,
    *::before,
    *::after {
        box-sizing: inherit;
    }

    html {
        box-sizing: border-box;
    }

    code {
        background-color: #9AA3AC;
        padding: 0 8px;
    }

</style>

<div style="padding: 10px 30px 30px 30px">
<div class="col-md-12 col-lg-12 col-offset-12 centered">
                    <br>
               

                    <div class="tg-box-links">
                        <a class="tg-link-img" style="align-items: center;" href="https://t.me/Registriegbot" > 
                        <img src="<?=Yii::$app->request->baseUrl?>/image/telegram.png" style="width: 35px; margin-right: 5px" alt="tg-rasmi"></a>
                        <a href="<?=\yii\helpers\Url::to(['/site/link'])?>" style="height: 10px; color: #337ba7; line-height: 18px; font-weight:600; font-weight: 13px; margin-bottom: 22px;" ><?php echo Yii::t('app','How did you hear about the event?'); ?></a>
                    </div>
                    
                

</br>
    <div class="smijoz-form">

        <div class="row" style="background-color: white; padding: 20px 10px 70px 0px">
            <div class="col-md-6">
                <div class="login100-pic js-tilt" style="margin-top: 120px" data-tilt>
                    <img src="<?=Yii::$app->request->baseUrl?>/temp/Login_v1/images/logo_ICT_2019.jpg" alt="IMG">
                </div>
            </div>
            <div class="col-md-6">
                <img src="<?=Yii::$app->request->baseUrl?>/temp/Login_v1/images/ictweek2019.jpg" alt="IMG">
                <span style="font-size: 50px;margin-left: 30px"><b><?php echo Yii::t('app','Registrathion'); ?></b>
                </span>
                <div style=" margin-top: 8px" class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','Name Surname'); ?></p></label>
                    <input class="form-control" type="text" name="name" required  placeholder="<?php echo Yii::t('app','Name Surname'); ?>">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required">

                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','Country'); ?></p></label>
                    <br>

                    <input type="radio" name="radio" checked id="radio" onclick="myFunction()"> <label  style="font-size: 14px;" for="radio"><p style="font-size: 14px;"><?php echo Yii::t('app','Resident'); ?></p></label>
                    <input type="radio" name="radio" id="radio1" onclick="meFunction()"> <label  style="font-size: 14px;" for="radio1"><p style="font-size: 14px;"><?php echo Yii::t('app','Non-resident'); ?></p></label>

                    <!-- <div  id="myDIV" style="display: block">
                        <input class="form-control" name="dav1" type="text" value="" readonly>
                    </div> -->
                    <div  id="myDI" style="display: none">
                        <?php
                        echo Select2::widget([
                            'name' => 'dav',

                            'data' => $data,
                            'options' => ['placeholder' => Yii::t('app','Country')],
                            'pluginOptions' => [
                                'allowClear' => true,

                            ],
                        ]);
                        ?></div>
                        </div> 
                        <div  id="myd2" style="display: flex">
                        <?php
                        echo Select2::widget([
                            'name' => 'obl',

                            'data' => $dataobl,
                            'options' => ['placeholder' => Yii::t('app','Viloyatlar')],
                            'pluginOptions' => [
                                'allowClear' => true,

                            ],
                        ]);
                        ?></div>
                    <!--                    
                    <input class="input100" type="text" name="dav" placeholder="--><?php //echo Yii::t('app','Country'); ?><!--">-->
                    <span class="focus-input100"></span>
                
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','Сompany'); ?></p></label>
                    <input class="form-control" type="text" name="tash" placeholder="<?php echo Yii::t('app','Сompany'); ?>">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','Scope of Activity'); ?></p></label>
                    <input class="form-control" type="text" name="lav" placeholder="<?php echo Yii::t('app','Scope of Activity'); ?>">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','E-mail'); ?></p></label>
                    <input class="form-control" type="email" name="email" placeholder="<?php echo Yii::t('app','E-mail'); ?>">
                    <input type="text" value="7" hidden name="tadbir">
                    <span class="focus-input100"></span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','Phone'); ?></p></label>
                    <input class="form-control" type="text" value="998" name="tel" placeholder="<?php echo Yii::t('app','Phone'); ?>">
                    <span class="focus-input100"></span>
                </div>
                <input type="text" name="created_at" value="<?= date("Y-m-d H:i:s")?>" hidden>
                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','How did you hear about the exhibition?'); ?></p></label>


                    <select class="form-control" style="color: #a39aa7" required name = "sel">
                        <option value="" style="color: " disabled selected hidden><?php echo Yii::t('app','How did you hear about the exhibition?'); ?></option>
                        <!--                                    <option value="радио"></option>-->
                        <!--                                    <option value="ТВ ">--><?php //echo Yii::t('app','radio'); ?><!-- </option>-->
                        <option value="1"><?php echo Yii::t('app','TV'); ?></option>
                        <option value="2"><?php echo Yii::t('app','E-mail sending'); ?></option>
                        <option value="3"><?php echo Yii::t('app','Outdoor advertising'); ?></option>
                        <!--                                    <option value="рассылка почтой ">--><?php //echo Yii::t('app','mailing'); ?><!--</option>-->
                        <option value="4"><?php echo Yii::t('app','Internet'); ?></option>
                        <option value="5"> <?php echo Yii::t('app','Other sources'); ?></option>
                    </select>

                </div>
                <button class="login100-form-btn">
                    <?php echo Yii::t('app','Save'); ?>
                </button>

            </div>
        </div>


    </div>
</div>



<?php ActiveForm::end(); ?>


<script>
    function myFunction() {
        var x = document.getElementById("myDI");
        var y = document.getElementById("myd2");

            x.style.display = "none";
            y.style.display = "block";
    
    }
    function meFunction() {

        var x = document.getElementById("myDI");
        var y = document.getElementById("myd2");
        x.style.display = "block";
        y.style.display = "none";
    }



</script>