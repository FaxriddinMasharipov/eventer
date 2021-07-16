<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\bootstrap\Modal;
use kartik\grid\GridView;
use johnitvn\ajaxcrud\CrudAsset; 
use johnitvn\ajaxcrud\BulkButtonWidget;

$this->title = 'Haridorlar qarzdorligi';
CrudAsset::register($this);
?>


<div class="client-qarz">
    <div class="row">
        <?php ActiveForm::begin()?>
        <div class="col-md-3 client-qarz__date">
            <?php
            echo DatePicker::widget([
                'name' => 'date1',
                'value' => Yii::$app->request->post('date1')?Yii::$app->request->post('date1'):date('Y-m-01'),
                'options' => ['placeholder' => 'Sanani tanlang...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>
        <div class="col-md-3 client-qarz__date">
            <?php
            echo DatePicker::widget([
                'name' => 'date2',
                'value' => Yii::$app->request->post('date2')?Yii::$app->request->post('date2'):date('Y-m-d'),
                'options' => ['placeholder' => 'Sanani tanlang...'],
                'pluginOptions' => [
                    'format' => 'yyyy-mm-dd',
                    'todayHighlight' => true
                ]
            ]);
            ?>
        </div>
        <div class="col-md-4 client-qarz__select2">
            <?php
            echo \kartik\select2\Select2::widget([
                'name' => 'haridor',
                'id' => 'haridor',
                'data' => $haridorlar,
                'value'=>Yii::$app->request->post('haridor'),
                'options' => ['placeholder' => 'Haridor nomi...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])
            ?>
        </div>
        <div class="col-md-1 client-qarz__button">
            <button id="qidirish" type="submit" class="btn btn-primary">Qidirish</button>
        </div>
        <?php ActiveForm::end()?>
    </div>
    <hr>
    <div class="info-qarz">
        <div class="info-qarz__item"><label for="">Boshlang'ich qarz:</label><span><?= $danq?></span></div>
        <div class="info-qarz__item"><label for="">Chiqim:</label><span><?= $chiqim?></span></div>
        <div class="info-qarz__item"><label for="">Kirim:</label><span><?= $kirim?></span></div>
        <div class="info-qarz__item"><label for="">Oxirgi qarz:</label><span><?= $gachaq?></span></div>
    </div>
    <hr>

    <?php
    echo \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',],
            'sana','diler_id','summa','qarz_summa','qarz_izoh',
        ],
        'summary' => 'Topilgan ma`lumotlar: <b>{totalCount}</b>',
//        'summary' => '{begin} - {end} {count} {totalCount} {page} {pageCount}',
        'emptyText'=>'Ma`lumot topilmadi',
        'layout'=> "{summary}\n{items}\n{pager}"
    ]);
    ?>
    <?php \yii\bootstrap\Modal::begin([
        'header' => '<h2>Yangi To`lovnoma</h2>
        <h4>"№" <input type="number" name="n_pl" value="" id="n_pl"></h4><h4>Sana '.
        DatePicker::widget(['name' => 'd_pl','id' => 'd_pl','value' => date('Y-m-d'),
                'options' => ['placeholder' => 'Sanani tanlang...'],
                'pluginOptions' => ['format' => 'yyyy-mm-dd','todayHighlight' => true]
            ]).'</h4>
        <h4>"Summa" <input type="number" name="summa_pl" value="" id="sena_pl"></h4>
        <h4>"Dollar" <input type="number" name="sena_d" value="" id="sena_d"></h4>
        <h4>Turi <select style="width: 200px;" id="vid"><option value="7">naqd kirim</option><option value="8">Qarz berish</option><option value="20">plastik kirim</option></select></h4>
        <h4>"Izoh" <input type="text" name="prim" value="" id="prim"></h4>
        <button type="button" style="font-size: 30px"  id="saqla_pl_new">Saqlash</button>',
        'id' => 'okno_k','class' => 'okno_k','size' => 'modal-lg',
        'toggleButton' => ['label' => 'Yangi to`lov','id' => 'pl_new','tag'=>'button','class' => 'nom',],
    'footer' => '',
    ]);
    ?>
    <?php \yii\bootstrap\Modal::end(); ?>
    <div  style="background-color: white; padding: 3px">
                <span>To`lovnomalar</span><span>+</span>
        <table class="table table-striped table-bordered" border="1" style="padding: 5px"  id="myTable">
            <thead>
            <tr>
                <th></th><th>№</th><th>Sana</th><th>Summa</th><th>Dollar</th><th>Turi</th><th>Izoh</th><th>Ma`sul</th>
            </tr>

            </thead>
            <?php $i=0; foreach ($pl as $ite) { $i++?>
            <tr id=<?= $ite['id'] ?>>
                <td>
                <?php \yii\bootstrap\Modal::begin([
        'header' => '<h2>tahrirlash</h2>
        <h4>"№" <input type="number" name="n_pl" value="'.$ite['n_pl'].'" class="n_pl'.$ite['id'].'"></h4><h4>Sana '.
        DatePicker::widget(['name' => 'd_pl','id' => 'd_pl'.$ite['id'].'','value' => $ite['d_pl'],
                'options' => ['placeholder' => 'Sanani tanlang...'],
                'pluginOptions' => ['format' => 'yyyy-mm-dd','todayHighlight' => true]
            ]).'</h4>
        <h4>"Summa" <input type="number" name="sena_pl" value="'.$ite['sena_pl'].'" class="sena_pl'.$ite['id'].'"></h4>
        <h4>"Dollar" <input type="number" name="sena_d" value="'.$ite['sena_d'].'" class="sena_d'.$ite['id'].'"></h4>
        <h4>Turi <select style="width: 200px;" class="vid'.$ite['id'].'" ><option value="7" '.($ite['vid']=='7' ? 'selected' : '').'>naqd kirim</option><option value="8" '.($ite['vid']=='8' ? 'selected' : '').'>Qarz berish</option><option value="20" '.($ite['vid']=='20' ? 'selected' : '').'>plastik kirim</option></select></h4>
        <h4>"Izoh" <input type="text" name="prim" value="'.$ite['prim'].'" class="prim'.$ite['id'].'"></h4>
        <button type="button" id = "'.$ite['id'].'" class="saqla_pl">Saqlash</button>',
        'toggleButton' => ['label' => '+','tag'=>'button','class' => 'toggle'.$ite['id'].'',],
    'footer' => '',
    ]);
    ?>
    <?php \yii\bootstrap\Modal::end(); ?>
                </td>
                <td><span><?= $ite['n_pl']?></span></td>
                <td><span><?= $ite['d_pl']?></span></td>
                <td><span><?= $ite['sena_pl']?></span></td>
                <td><span><?= $ite['sena_d']?></span></td>
                <td><span><?= $ite['nom']?></span></td>
                <td><span><?= $ite['prim']?></span></td>
                <td><span><?= $ite['fio']?></span></td>
                
            </tr>
            <?php }?>
        </table>
    </div>
</div>
<style>
    #myTable {
            border-collapse: collapse; /* Collapse borders */
            width: 100%; /* Full-width */   
            border: 1px solid #ddd; /* Add a grey border */
            /*font-size: 18px; !* Increase font-size *!*/
        }
    .info-qarz{
        margin: 20px 0;
    }
    .info-qarz__item{
        display: inline-block;
    }
    .info-qarz__item label {
        text-align: right;
        width: 130px;
        margin-right: 12px;
    }
    .info-qarz__item span {
        display: inline-block;
        width: 120px;
        border: 1px solid #ccc;
        padding: 1px 4px;
        border-radius: 4px;
    }
    @media only screen and (max-width: 1280px) {
        .info-qarz__item{
            width: 49%;
        }
    }
    @media only screen and (max-width: 1086px) {
        .client-qarz__date, .client-qarz__select2, .client-qarz__button{
            padding-top: 2px;
            padding-bottom:2px;
        }
        .client-qarz__button{
            text-align: right;
        }
    }
    @media only screen and (max-width: 564px) {
        .info-qarz__item label {
            text-align: left;
            margin-right: 0;
        }
    }
</style>
<script type="text/javascript">
$('.saqla_pl').on('click',function(e){
    e.preventDefault();
    var jid=$(this).attr('id');
    //alert($("#haridor").val());
    if($("#haridor").val()==="")
    {alert("Haridorni tanlang");$('.modal').modal('hide');return false;}

    $.ajax({url: '<?php echo Yii::$app->request->baseUrl.'/site/pledit'?>',
        type: 'POST',
        data: {id:jid,n_pl:$(".n_pl"+jid).val(),d_pl:$("#d_pl"+jid).val(),vid:$(".vid"+jid).val(),sena_pl:$(".sena_pl"+jid).val(),sena_d:$(".sena_d"+jid).val(),prim:$(".prim"+jid).val(),h_id:$("#haridor").val()},
        success: function(data){alert(data+' - sonli to`lovnoma tahrirlandi');
                $('.modal').modal('hide');
                $('#qidirish').click();
                }
        ,error: function(){alert('Diqqat !!! hatolik yuz berdi');}
    });
});
$('#saqla_pl_new').on('click',function(e){
    e.preventDefault();
    //alert($("#haridor").val());
    if($("#haridor").val()==="")
    {alert("Haridorni tanlang");$('.modal').modal('hide');return false;}

    $.ajax({url: '<?php echo Yii::$app->request->baseUrl.'/site/pladd'?>',
        type: 'POST',
        data: {n_pl:$("#n_pl").val(),d_pl:$("#d_pl").val(),vid:$("#vid").val(),sena_pl:$("#sena_pl").val(),sena_d:$("#sena_d").val(),prim:$("#prim").val(),h_id:$("#haridor").val()},
        success: function(data){alert(data+' - sonli yangi to`lovnoma qo`shildi');
                $('.modal').modal('hide');
                $('#qidirish').click();
                }
        ,error: function(){alert('Diqqat !!! hatolik yuz berdi');}
    });
});        

</script>