<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '';
$model = \frontend\models\STovar::find()->all();
$data = \yii\helpers\ArrayHelper::map($model,'id','nom');
?>
<?php
$date = date("Y-m-d");
$s = \frontend\models\Asos::find()->andWhere(['diler_id'=>0])->one();
?>

    <br>
    <br>
<?php
$date = date("Y-m-d");
$s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
$ss = \frontend\models\AsosSlave::find()->where(['asos_id'=>$s['id']])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
if($ss['id']==null){ ?>
    <?php ActiveForm::begin(['action'=>['/site/addnew']])?>
    <!-- <input type="text" value="2" class = "sotinput" name = "sotinput"> -->
    <div class="col-md-4 haridor-select2">
        <?php
        echo \kartik\select2\Select2::widget([
            'name' => 'haridor',
            'data' => $haridorlar,
            'value'=>$s['h_id'],
            'options' => ['placeholder' => 'Haridor nomi...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])
        ?>
    </div>
    <p>
    <input type='radio' id='1' class="sottur" name='drone' value='1'>
    <label for='1'>ch</label>
    <input type='radio' id='2' class="sottur" name='drone' value='2' checked>
    <label for='2'>ulg1</label>
    <input type='radio' id='3' class="sottur" name='drone' value='3'>
    <label for='3'>ulg1 pl</label>
    <input type='radio' id='4' class="sottur" name='drone' value='4'>
    <label for='4'>ulg2</label>
    <input type='radio' id='5' class="sottur" name='drone' value='5'>
    <label for='5'>ulg2_pl</label>
    </p>
    <button style="margin-top: 0px" class="btn btn-primary form-control">&nbsp; &nbsp;<i class="fa fa-search"></i>&nbsp; &nbsp;</button>
    <?php ActiveForm::end()?>
<?php }
else{
    ?>
    <div class="table-responsive panel panel-default" style="padding: 5px; margin-top: -50px">
        <table class="table table-bordered">
            <?php $i=0;
            foreach ($sotil as $sotaman){ $i++?>
                <tbody style="">
                <tr>
                    <th style="background-color: rgba(65,114,246,0.77); color: white" scope="row">№<?=$i?>:<?= mb_substr($sotaman->tovar_nom,0,24)?>...</th>
                    <th style="background-color: rgba(65,114,246,0.77); color: black" >
                        <?php ActiveForm::begin()?>
                        <input type="text" value="<?=$sotaman->id?>" name="iddel" hidden>
                        <input type="text" value="<?=$sotaman->kol_ost?>" name="idav" hidden>
                        <input type="text" value="<?=$sotaman->kol?>" name="koldel" hidden >
                        <input type="text" value="<?=$sotaman->kol_in?>" name="kolindel" hidden>
                        <button onclick="return confirm('Ochirilsinmi?')"><i class="fa fa-trash"></i></button>
                        <?php ActiveForm::end()?>
                    </th>
               </tr>
                <?php ActiveForm::begin(['action'=>['/site/karzina']])?>
                <?php if($sotaman->kol==0){
                }
                else{
                    ?>
                <tr>
                    <th style="color: blue" scope="row">

                        <div class="quantity">
                            Asosiy:
                            <button class="plus-btn" type="button" name="button">
                                +
                            </button>
                            <input style="width: 50px; text-align: center" max="" type="number" name="kol" value="<?=$sotaman->kol?>">
                            <button class="minus-btn" type="button" name="button">
                                -
                            </button> x  <b style="color: red"><?=$sotaman->sotish?></b> = <b style="color: red"><?=$sotaman->kol * $sotaman->sotish?></b>
                        </div>
                    </th>
                    <th style="color: blue" >
                        <input type="text" hidden value="<?=$sotaman->kol_ost?>" name="ides">
                        <input type="text" hidden value="<?=$sotaman->kol?>" name="koles">
                        <input type="text" hidden value="<?=$sotaman->kol_in?>" name="kolines">
                        <input type="text" hidden value="<?=$sotaman->id?>" name="idjo">
                        <input type="text" hidden value="<?=$sotaman->sotish?>" name="sotishjo">
                        <input type="text" hidden value="<?=$sotaman->sotish_in?>" name="sotishinjo">
                        <button onclick="return confirm('Yangilansinmi?')"><i class="fa fa-pencil"></i></button>
                    </th>
                </tr>
                        <?php
                        $a= $sotaman->kol * $sotaman->sotish;
                        $c+= $a;
                        $e= $sotaman->kol;
                        $f= $sotaman->kol_in;
                        $h+=$e;
                        $l+=$f;
                        ?>
                        </th></tr>
                <?php }?>
                <?php if($sotaman->kol_in==0){}
                else{
                ?>
                <tr>
                    <th style="color: blue" scope="row">

                        <div class="quantity">
                            Ichki:&nbsp;&nbsp;&nbsp;
                            <button class="plus-btn" type="button" name="button">+</button>
                            <input style="width: 50px; text-align: center" max="" type="number" name="kolin" value="<?=$sotaman->kol_in?>">
                            <button class="minus-btn" type="button" name="button">-</button> x <b style="color: red"> <?=$sotaman->sotish_in?></b> = <b style="color: red"><?=$sotaman->kol_in * $sotaman->sotish_in ?></b>

                        </div>
                        <?php
                        $la=$sotaman->kol_in*$sotaman->sotish_in;
                        $lal+=$la;

                        ?>
                    </th>
                    <th style="color: blue" >

                        <input type="text" hidden value="<?=$sotaman->kol_ost?>" name="ides">
                        <input type="text" hidden value="<?=$sotaman->kol?>" name="koles">
                        <input type="text" hidden value="<?=$sotaman->kol_in?>" name="kolines">
                        <input type="text" hidden value="<?=$sotaman->id?>" name="idjo">
                        <button onclick="return confirm('Yangilansinmi?')"><i class="fa fa-pencil"></i></button>
                    </th>
                </tr>
                <?php }?>
                <?php ActiveForm::end()?>
                </tbody>
            <?php } ?>
        </table>
        <hr style="color: #00b3ee">
        <table>
            <tr><td style="background-color: rgba(65,114,246,0.77); color: white; padding: 3px">
                    <?php
                    $sum1 = \frontend\models\AsosSlave::find()->where(['asos_id'=>$s['id']])->one();
                    $sum = $sum1['sotish']*$sum1['kol'];
                    $sumin = $sum1['sotish_in']*$sum1['kol_in'];
                    ?>
                    Jami: </td>
                <td style="background-color: red; color: white"> Soni =  <?=$h+$l?> </td>
                <td style="background-color: rgba(65,114,246,0.77); color: white; padding: 3px">summa:</td>
                <td style="background-color: red;color: white;  padding: 3px"><?= $c+$lal ?></td>
            </tr>
            <tr >
                <td>
                    <?php ActiveForm::begin(['action'=>['/site/karzina']])?>
                    <?php
                    $date = date("Y-m-d");
                    $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
                    $klient = \frontend\models\SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
                    $garpil= $klient['garaj']+1;
                    ?>
                    <input type="text" hidden value="<?=$garpil?>" name="garaj">

                    <input type="text" hidden value="<?=$s['id']?>" name="andnac">
                    <input type="text" value="<?= $sum+$sumin ?>" hidden name="summa">
                    <input type="text" value="<?= $sum1['kol']+$sum1['kol_in'] ?>" hidden name="kols">
                    <button class="btn btn-info" onclick="return confirm('Saqlansinmi?')" style="margin-top: 10px; font-size: 12px">Saqlash</button>

                    <?php ActiveForm::end()?>

                </td>
                <td>
                    <?php ActiveForm::begin(['action'=>['/site/karzina']])?>
                    <?php
                    $date = date("Y-m-d");
                    $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
                    ?>
                    <input type="text" hidden value="<?=$s['id']?>" name="andnacdel">
                    <button class="btn btn-danger" onclick="return confirm('Tozalansinmi?')" style="margin-top: 10px; font-size: 12px"> Tozalash</button>
                    <?php ActiveForm::end()?>
                </td>

                <td>

                    <?php ActiveForm::begin(['action'=>['/site/karzina']])?>

                    <?php
                    $date = date("Y-m-d");
                    $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
                    $klient = \frontend\models\SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
                    $garpil= $klient['garaj']+1;
                    ?>
                    <input type="text" hidden value="<?=$garpil?>" name="garaj">
                    <input type="text" hidden value="<?=$s['id']?>" name="andchek">
                    <input type="text" value="<?= $sum+$sumin ?>" hidden name="summa">
                    <input type="text" value="<?= $sum1['kol']+$sum1['kol_in'] ?>" hidden name="kols">
                    <button class="btn btn-primary" onclick="return confirm('Chek chiqarilsinmi?')" style="margin-top: 10px; font-size: 12px">Chek</button></td>

                <?php ActiveForm::end()?>
                 <td>

                    <?php ActiveForm::begin(['action'=>['/site/karzina']])?>

                     <?php
                     $date = date("Y-m-d");
                     $s = \frontend\models\Asos::find()->where(['sana'=>$date])->andWhere(['diler_id'=>0])->andWhere(['user_id'=>Yii::$app->getUser()->id])->one();
                     $klient = \frontend\models\SClient::find()->where(['id'=>Yii::$app->getUser()->identity->client_id])->one();
                     $garpil= $klient['garaj']+1;
                     ?>
                     <input type="text" hidden value="<?=$garpil?>" name="garaj">
                     <input type="text" hidden value="<?=$s['id']?>" name="andfaktur">
                     <button class="btn btn-info" style="margin-top: 10px; font-size: 12px" onclick="return confirm('Bajarilsinmi?')"> Faktur </button><td>
                <?php ActiveForm::end()?>
                <td></td><td></td>
                <?php ActiveForm::begin(['action'=>['/site/addnew']])?>
                </tr>
                <tr><td colspan="7">-----------------------------------------------------
                </td></tr>
                <tr><td colspan="7">
                
                    <?php
                    echo \kartik\select2\Select2::widget([
                        'name' => 'haridor',
                        'data' => $haridorlar,
                        'value'=>$s['h_id'],
                        'options' => ['placeholder' => 'Haridor nomi...'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ])
                    ?>
                
                </td></tr>
                <tr>
                <td colspan="7">
                   
                   </br>     
                    <p>
                    <input type='radio' id='1' class="sottur" name='drone' value='1'>
                    <label for='1'>ch</label>
                    <input type='radio' id='2' class="sottur" name='drone' value='2' checked>
                    <label for='2'>ulg1</label>
                    <input type='radio' id='3' class="sottur" name='drone' value='3'>
                    <label for='3'>pl1</label>
                    <input type='radio' id='4' class="sottur" name='drone' value='4'>
                    <label for='4'>ulg2</label>
                    <input type='radio' id='5' class="sottur" name='drone' value='5'>
                    <label for='5'>pl2</label>
                    </p>

                    <button style="margin-top: 0px" class="btn btn-primary form-control">&nbsp; &nbsp;<i class="fa fa-search"></i>&nbsp; &nbsp;</button>

                    <?php ActiveForm::end()?>
                </td>
                </tr>
            </tr>
        </table>
    </div>
<?php }
?>
<style type="text/css">
input {
            /*background-image: url('/css/searchicon.png'); !* Add a search icon to input *!*/
            /*background-position: 10px 12px; !* Position the search icon *!*/
            /*background-repeat: no-repeat; !* Do not repeat the icon image *!*/
            width: 5%; /* Full-width */
            font-size: 14px; /* Increase font-size */
            /*padding: 6px 20px 6px 40px; !* Add some padding *!*/
            padding: 6px 10px;
            border: 1px solid #ddd; /* Add a grey border */
            margin-bottom: 12px; /* Add some space below the input */
            border-radius: 4px;
        }
</style>
<script type="text/javascript">
    $('.minus-btn').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());

        if (value > 1) {
            value = value - 1;
        } else {
            value = 0;
        }

        $input.val(value);

    });

    $('.plus-btn').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());

        if (value < 100) {
            value = value + 1;
        } else {
            value =100;
        }

        $input.val(value);
    });

    $('.like-btn').on('click', function() {
        $(this).toggleClass('is-active');
    });
</script>
