<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */

$this->title = '';
$all=\frontend\models\AppsCountries::find()->all();
$data = \yii\helpers\ArrayHelper::map($all,'id','country_name')
?>
<?php $form = ActiveForm::begin(['action'=>['/site/tqrcode']]); ?>
<div style="float: right">
    <button style=" color: white; position: fixed; top: 20%; height: 40px; width: 80px; margin: 0px 0px 0px -95px" class="login100-form-btn">
        <?php echo Yii::t('app','Tekshirish'); ?>
    </button></div>
<style>
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
<div style="padding: 30px 30px 30px 30px">
    <div class="smijoz-form">


        <div class="row" style="background-color: white; padding: 20px 70px 20px 0px">
            <div class="col-md-6">

                <div class="login100-pic js-tilt" style="margin-top: 20px" data-tilt>

                    <img src="<?=Yii::$app->request->baseUrl?>/temp/Login_v1/images/img-01.png" alt="IMG">

                </div>
            </div>
            <div class="col-md-6" >
                <br>

                <br>
                <br>
                <br>
                <h2 style="text-align: center"><b><?php echo Yii::t('app','Tekshiruv'); ?></b>

                </h2>


                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <label for=""><p style="font-size: 14px;"><?php echo Yii::t('app','Phone'); ?></p></label>
                    <input class="form-control" style="height:60px;" type="text" value="998" name="tel" placeholder="<?php echo Yii::t('app','Phone'); ?>">
                    <span class="focus-input100"></span>
                </div>

            </div>
        </div>


    </div>
</div>



<?php ActiveForm::end(); ?>


<script>
    function myFunction() {
        var x = document.getElementById("myDIV");
        var y = document.getElementById("myDI");

        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
        if (y.style.display === "none") {
            y.style.display = "block";
        } else {
            y.style.display = "none";
        }
    }
    function meFunction() {

        var x = document.getElementById("myDI");
        var y = document.getElementById("myDIV");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
        if (y.style.display === "block") {
            y.style.display = "none";
        } else {
            y.style.display = "block";
        }
    }



</script>